<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */

	 public function actionprivacy()
	 {
		  $this->render('privacy');
	 }


	 
	 public function actionAuditReports()
	 {
		  // Get the current user's firm ID
		  $currentUserFirmId = null;
		  $currentUserId = Yii::app()->user->id;
		  
		  if ($currentUserId) {
			  $userData = Yii::app()->db->createCommand()
				  ->select('firmid')
				  ->from('user')
				  ->where('id=:id', array(':id'=>$currentUserId))
				  ->queryRow();
			  
			  if ($userData && isset($userData['firmid'])) {
				  $currentUserFirmId = $userData['firmid'];
			  }
		  }
		  
		  if(!$currentUserFirmId) {
			  $currentUserFirmId = 1; // Default to firm ID 1 if not set
		  }
		  
		  // Get workorders with visittype 109, belonging to the current user's firm, and with status 3
		  $workorders = Yii::app()->db->createCommand()
			  ->select('w.*, c.name as customer_name, u.username as technician_name')
			  ->from('workorder w')
			  ->leftJoin('client c', 'w.clientid = c.id')
			  ->leftJoin('user u', 'w.staffid = u.id')
			  ->where('w.visittypeid = :visittype_id AND w.firmid = :firm_id AND w.status = :status', 
				  array(':visittype_id' => 109, ':firm_id' => $currentUserFirmId, ':status' => 3))
			  ->order('w.id DESC')
			  ->queryAll();
		  
		  $this->render('auditreports', array(
			  'workorders' => $workorders
		  ));
	 }

     public function actionViewauditreport($id)
     {
          // Create the audit_report_items table if it doesn't exist
          $connection = Yii::app()->db;
          $command = $connection->createCommand("CREATE TABLE IF NOT EXISTS `audit_report_items` (
              `id` int NOT NULL AUTO_INCREMENT,
              `workorder_id` int NOT NULL,
              `name` varchar(255) NOT NULL,
              `category_id` int NOT NULL,
              `description` text,
              `questions` longtext,
              `creator_id` int DEFAULT NULL,
              `firm_id` int DEFAULT NULL,
              `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `result` int DEFAULT 100,
              PRIMARY KEY (`id`),
              KEY `workorder_id` (`workorder_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;");
          $command->execute();
          
          // Check if the audit_id column exists, if not add it
          $tableSchema = $connection->schema->getTable('audit_report_items');
          if ($tableSchema && !isset($tableSchema->columns['audit_id'])) {
              try {
                  $connection->createCommand("ALTER TABLE `audit_report_items` 
                      ADD COLUMN `audit_id` int DEFAULT 0 AFTER `workorder_id`, 
                      ADD INDEX `audit_id` (`audit_id`)")->execute();
              } catch (Exception $e) {
                  // Ignore errors if column already exists
              }
          }
          
          // Check if the result column exists, if not add it
          if ($tableSchema && !isset($tableSchema->columns['result'])) {
              try {
                  $connection->createCommand("ALTER TABLE `audit_report_items` 
                      ADD COLUMN `result` int DEFAULT 100")->execute();
                  error_log('Added result column to audit_report_items table');
              } catch (Exception $e) {
                  error_log('Error adding result column: ' . $e->getMessage());
                  // Ignore errors if column already exists
              }
          }
          
          // Check if we need to update existing records with audit_id
          $needsMigration = false;
          try {
              $emptyAuditIds = $connection->createCommand()
                  ->select('COUNT(*)')
                  ->from('audit_report_items')
                  ->where('audit_id = 0 OR audit_id IS NULL')
                  ->queryScalar();
              
              if ($emptyAuditIds > 0) {
                  $needsMigration = true;
              }
          } catch (Exception $e) {
              // Ignore errors
          }
          
          // Run migration if needed
          if ($needsMigration) {
              try {
                  // Get all audits with empty audit_id
                  $itemsToUpdate = $connection->createCommand()
                      ->select('id, name, firm_id')
                      ->from('audit_report_items')
                      ->where('audit_id = 0 OR audit_id IS NULL')
                      ->queryAll();
                  
                  foreach ($itemsToUpdate as $item) {
                      // Find matching audit in audits table by name and firm_id
                      $matchingAudit = $connection->createCommand()
                          ->select('id')
                          ->from('audits')
                          ->where('name = :name AND firm_id = :firm_id', 
                              array(':name' => $item['name'], ':firm_id' => $item['firm_id']))
                          ->queryRow();
                      
                      if ($matchingAudit) {
                          // Update the audit_report_items record with the correct audit_id
                          $connection->createCommand()
                              ->update('audit_report_items', 
                                  array('audit_id' => $matchingAudit['id']), 
                                  'id = :id', array(':id' => $item['id']))
                              ->execute();
                      }
                  }
              } catch (Exception $e) {
                  // Ignore migration errors
              }
          }
          
          // Get the current user's firm ID
          $currentUserFirmId = null;
          $currentUserId = Yii::app()->user->id;
          
          if ($currentUserId) {
              $userData = Yii::app()->db->createCommand()
                  ->select('firmid')
                  ->from('user')
                  ->where('id=:id', array(':id'=>$currentUserId))
                  ->queryRow();
              
              if ($userData && isset($userData['firmid'])) {
                  $currentUserFirmId = $userData['firmid'];
              }
          }
          
          if(!$currentUserFirmId) {
              $currentUserFirmId = 1; // Default to firm ID 1 if not set
          }
          
          // Get the workorder
          $workorder = Yii::app()->db->createCommand()
              ->select('w.*, c.name as customer_name, u.username as technician_name')
              ->from('workorder w')
              ->leftJoin('client c', 'w.clientid = c.id')
              ->leftJoin('user u', 'w.staffid = u.id')
              ->where('w.id = :id AND w.firmid = :firm_id', 
                  array(':id' => $id, ':firm_id' => $currentUserFirmId))
              ->queryRow();
          
          if (!$workorder) {
              Yii::app()->user->setFlash('error', 'Workorder not found or you do not have permission to view it.');
              $this->redirect(array('auditreports'));
              return;
          }
          
          // Get all audit report items for this workorder
          $auditReportItems = Yii::app()->db->createCommand()
              ->select('*')
              ->from('audit_report_items')
              ->where('workorder_id = :workorder_id', array(':workorder_id' => $id))
              ->queryAll();
          
          // Get all audits for selection
          $allAudits = Yii::app()->db->createCommand()
              ->select('a.*, c.name as category_name')
              ->from('audits a')
              ->leftJoin('audit_categories c', 'a.category_id = c.id')
              ->where('a.firm_id = :firm_id', array(':firm_id' => $currentUserFirmId))
              ->order('a.name ASC')
              ->queryAll();
          
          // Get IDs of audits already added to this report
          $addedAuditIds = array();
          foreach ($auditReportItems as $item) {
              if (isset($item['audit_id']) && $item['audit_id'] > 0) {
                  $addedAuditIds[] = $item['audit_id'];
              }
          }
          
          // Separate available and added audits
          $availableAudits = array();
          $addedAudits = array();
          
          foreach ($allAudits as $audit) {
              if (in_array($audit['id'], $addedAuditIds)) {
                  $addedAudits[] = $audit;
              } else {
                  $availableAudits[] = $audit;
              }
          }
          
          // Handle form submission for adding a new audit to the report
          if (isset($_POST['audit_id'])) {
              $auditId = $_POST['audit_id'];
              
              // Check if the audit exists and hasn't been added yet
              $selectedAudit = null;
              foreach ($allAudits as $audit) {
                  if ($audit['id'] == $auditId) {
                      $selectedAudit = $audit;
                      break;
                  }
              }
              
              // Check if this audit is already added to the report
              $alreadyAdded = in_array($auditId, $addedAuditIds);
              
              if ($selectedAudit && !$alreadyAdded) {
                  // Make sure we have a valid audit ID
                  $auditId = (int)$selectedAudit['id'];
                  
                  // Insert the audit into audit_report_items
                  $command = Yii::app()->db->createCommand();
                  $command->insert('audit_report_items', array(
                      'workorder_id' => $id,
                      'audit_id' => $auditId, // Ensure we're using the integer ID from the audits table
                      'name' => $selectedAudit['name'],
                      'category_id' => $selectedAudit['category_id'],
                      'description' => $selectedAudit['description'],
                      'questions' => $selectedAudit['questions'],
                      'creator_id' => $currentUserId,
                      'firm_id' => $currentUserFirmId
                  ));
                  
                  Yii::app()->user->setFlash('success', 'Audit added to report successfully.');
                  $this->redirect(array('viewauditreport', 'id' => $id));
              } else if ($alreadyAdded) {
                  Yii::app()->user->setFlash('error', 'This audit has already been added to the report.');
              } else {
                  Yii::app()->user->setFlash('error', 'Selected audit not found.');
              }
          }
          
          // Handle removing an audit from the report
          if (isset($_GET['remove'])) {
              $removeId = (int)$_GET['remove'];
              
              // Delete the audit report item
              $command = Yii::app()->db->createCommand();
              $command->delete('audit_report_items', 
                  'id = :id AND workorder_id = :workorder_id', 
                  array(':id' => $removeId, ':workorder_id' => $id));
              
              Yii::app()->user->setFlash('success', 'Audit removed from report successfully');
              $this->redirect(array('viewauditreport', 'id' => $id));
          }
          
          $this->render('viewauditreport', array(
              'workorder' => $workorder,
              'auditReportItems' => $auditReportItems,
              'availableAudits' => $availableAudits
          ));
     }
     
     public function actionFillaudititem($id, $item_id) {
          // Get the current user's firm ID
          $currentUserFirmId = null;
          $currentUserId = Yii::app()->user->id;
          
          // Get user's firm ID from the user table
          $userData = Yii::app()->db->createCommand()
              ->select('firmid')
              ->from('user')
              ->where('id=:id', array(':id'=>$currentUserId))
              ->queryRow();
          
          if ($userData && isset($userData['firmid'])) {
              $currentUserFirmId = $userData['firmid'];
          }
          
          if(!$currentUserFirmId) {
              $currentUserFirmId = 1; // Default to firm ID 1 if not set
          }
          
          // Get the workorder
          $workorder = Yii::app()->db->createCommand()
              ->select('w.*, c.name as client_name')
              ->from('workorder w')
              ->leftJoin('client c', 'w.clientid = c.id')
              ->where('w.id=:id AND w.firmid=:firm_id', 
                  array(':id'=>$id, ':firm_id'=>$currentUserFirmId))
              ->queryRow();
          
          if (!$workorder) {
              throw new CHttpException(404, 'Workorder not found.');
          }
          
          // Get the audit item
          $auditItem = Yii::app()->db->createCommand()
              ->select('*')
              ->from('audit_report_items')
              ->where('id=:id AND workorder_id=:workorder_id', 
                  array(':id'=>$item_id, ':workorder_id'=>$id))
              ->queryRow();
          
          if (!$auditItem) {
              throw new CHttpException(404, 'Audit item not found.');
          }
          
          // Parse the questions JSON
          $questions = json_decode($auditItem['questions'], true);
          
          // Get nonconformities for this workorder with department and subdepartment information
          $nonconformities = Yii::app()->db->createCommand()
              ->select('c.id, c.definition, c.departmentid, c.subdepartmentid, c.filesf, c.suggestion, c.priority, d1.name as department_name, d2.name as subdepartment_name')
              ->from('conformity c')
              ->leftJoin('departments d1', 'c.departmentid = d1.id')
              ->leftJoin('departments d2', 'c.subdepartmentid = d2.id')
              ->where('c.workorderid = :workorder_id', array(':workorder_id' => $id))
              ->queryAll();
          
          // Handle report publishing
          if (isset($_POST['publish_report'])) {
              $isPublished = (int)$_POST['publish_report'];
              
              // Update the is_published field in the database
              $command = Yii::app()->db->createCommand();
              $command->update('audit_report_items', 
                  array('is_published' => $isPublished),
                  'id=:id', array(':id'=>$item_id));
              
              // Set flash message
              if ($isPublished == 1) {
                  Yii::app()->user->setFlash('success', 'Rapor başarıyla yayınlandı.');
              } else {
                  Yii::app()->user->setFlash('info', 'Rapor yayından kaldırıldı.');
              }
              
              // Redirect to the same page to prevent form resubmission
              $this->redirect(array('fillaudititem', 'id'=>$id, 'item_id'=>$item_id));
          }
          
          // Handle form submission for saving audit answers
          if (isset($_POST['save_answers'])) {
              // Log the POST data for debugging
              error_log('POST data: ' . print_r($_POST, true));
              
              $answers = isset($_POST['answers']) ? $_POST['answers'] : array();
              $findings = isset($_POST['findings']) ? $_POST['findings'] : array();
              $actions = isset($_POST['actions']) ? $_POST['actions'] : array();
              $scores = isset($_POST['scores']) ? $_POST['scores'] : array();
              $timestamps = isset($_POST['timestamps']) ? $_POST['timestamps'] : array();
              // Recommendation kolonu kaldırıldı
              $nonconformityIds = isset($_POST['nonconformity_ids']) ? $_POST['nonconformity_ids'] : array();
              
              // Success rate değerini al
              $successRate = isset($_POST['success_rate']) ? (int)$_POST['success_rate'] : 100;
              error_log('Success Rate from form: ' . $successRate);
              
              // Denetçi, raporu yazan kişi ve raporu onaylayan kişi bilgilerini al
              $inspectorId = isset($_POST['inspector_id']) ? $_POST['inspector_id'] : null;
              $reportWriterId = isset($_POST['report_writer_id']) ? $_POST['report_writer_id'] : null;
              $reportApproverId = isset($_POST['report_approver_id']) ? $_POST['report_approver_id'] : null;
              
              // Log the extracted data for debugging
              error_log('Findings: ' . print_r($findings, true));
              error_log('Actions: ' . print_r($actions, true));
              error_log('Scores: ' . print_r($scores, true));
              error_log('Timestamps: ' . print_r($timestamps, true));
              error_log('Nonconformity IDs: ' . print_r($nonconformityIds, true));
              
              // Check if questions is a nested structure or flat array
              $isNestedStructure = is_array($questions) && isset($questions['questions']);
              
              if ($isNestedStructure) {
                  // Handle new nested structure with headers and questions
                  $questionsArray = $questions['questions'];
                  
                  // Update the questions with answers
                  foreach ($questionsArray as $key => $question) {
                      $questionId = $question['id'];
                      if (isset($answers[$questionId])) {
                          $questionsArray[$key]['answer'] = $answers[$questionId];
                      }
                      if (isset($findings[$questionId])) {
                          $questionsArray[$key]['findings'] = $findings[$questionId];
                      }
                      if (isset($actions[$questionId])) {
                          $questionsArray[$key]['corrective_action'] = $actions[$questionId];
                      }
                      if (isset($scores[$questionId])) {
                          $questionsArray[$key]['score'] = (int)$scores[$questionId];
                      }
                      if (isset($timestamps[$questionId])) {
                          $questionsArray[$key]['timestamp'] = $timestamps[$questionId];
                      }
                      // Recommendation kolonu kaldırıldı
                      if (isset($nonconformityIds[$questionId])) {
                          $questionsArray[$key]['nonconformity_ids'] = $nonconformityIds[$questionId];
                      }
                  }
                  
                  // Denetçi, raporu yazan kişi ve raporu onaylayan kişi bilgilerini ekle
                  $questions['inspector_id'] = $inspectorId;
                  $questions['report_writer_id'] = $reportWriterId;
                  $questions['report_approver_id'] = $reportApproverId;
                  
                  // Update the questions array in the nested structure
                  $questions['questions'] = $questionsArray;
              } else {
                  // Handle old flat array structure
                  foreach ($questions as $key => $question) {
                      $questionId = $question['id'];
                      if (isset($answers[$questionId])) {
                          $questions[$key]['answer'] = $answers[$questionId];
                      }
                      if (isset($findings[$questionId])) {
                          $questions[$key]['findings'] = $findings[$questionId];
                      }
                      if (isset($actions[$questionId])) {
                          $questions[$key]['corrective_action'] = $actions[$questionId];
                      }
                      if (isset($scores[$questionId])) {
                          $questions[$key]['score'] = (int)$scores[$questionId];
                      }
                      if (isset($timestamps[$questionId])) {
                          $questions[$key]['timestamp'] = $timestamps[$questionId];
                      }
                      // Recommendation kolonu kaldırıldı
                      if (isset($nonconformityIds[$questionId])) {
                          $questions[$key]['nonconformity_ids'] = $nonconformityIds[$questionId];
                      }
                  }
                  
                  // Flat array yapısı için, yeni bir meta veri dizisi oluştur
                   $questions = array(
                       'meta' => array(
                           'inspector_id' => $inspectorId,
                           'report_writer_id' => $reportWriterId,
                           'report_approver_id' => $reportApproverId
                       ),
                       'questions' => $questions
                   );
               }
              
              // Success rate değeri daha önce alındı, burada tekrar almaya gerek yok
               // $successRate değişkeni yukarıda tanımlandı ve değeri atandı
               
               // Log the received success rate for debugging
               error_log('Final success_rate to be saved: ' . print_r($successRate, true));
               
               // Ensure success rate is saved even if it's 100
               if (empty($successRate)) {
                   $successRate = 100; // Default to 100% if no value is provided
               }
              
              // Save the updated questions and success rate back to the database
              $command = Yii::app()->db->createCommand();
              $command->update('audit_report_items', 
                  array(
                      'questions' => json_encode($questions),
                      'result' => $successRate
                  ),
                  'id=:id', array(':id'=>$item_id));
              
              Yii::app()->user->setFlash('success', 'Audit answers saved successfully.');
          }
          
          $this->render('fillaudititem', array(
              'workorder' => $workorder,
              'auditItem' => $auditItem,
              'questions' => $questions,
              'nonconformities' => $nonconformities,
          ));
     }
     
     public function actionDownloadauditreport($id)
     {
          // Get the current user's firm ID
          $currentUserFirmId = null;
          $currentUserId = Yii::app()->user->id;
          
          if ($currentUserId) {
              $userData = Yii::app()->db->createCommand()
                  ->select('firmid')
                  ->from('user')
                  ->where('id=:id', array(':id'=>$currentUserId))
                  ->queryRow();
              
              if ($userData && isset($userData['firmid'])) {
                  $currentUserFirmId = $userData['firmid'];
              }
          }
          
          if(!$currentUserFirmId) {
              $currentUserFirmId = 1; // Default to firm ID 1 if not set
          }
          
          // Get the workorder
          $workorder = Yii::app()->db->createCommand()
              ->select('w.*, c.name as customer_name, u.username as technician_name')
              ->from('workorder w')
              ->leftJoin('client c', 'w.clientid = c.id')
              ->leftJoin('user u', 'w.staffid = u.id')
              ->where('w.id = :id AND w.firmid = :firm_id', 
                  array(':id' => $id, ':firm_id' => $currentUserFirmId))
              ->queryRow();
          
          if (!$workorder) {
              Yii::app()->user->setFlash('error', 'Workorder not found or you do not have permission to view it.');
              $this->redirect(array('auditreports'));
              return;
          }
          
          // Get all audit report items for this workorder
          $auditReportItems = Yii::app()->db->createCommand()
              ->select('*')
              ->from('audit_report_items')
              ->where('workorder_id = :workorder_id', array(':workorder_id' => $id))
              ->queryAll();
          
          // For now, just redirect back to the view page
          // In a real implementation, this would generate a PDF
          Yii::app()->user->setFlash('info', 'PDF download functionality will be implemented soon.');
          $this->redirect(array('viewauditreport', 'id' => $id));
     }
	 
	 public function actionAudits()
	 {
		  // Create the audits table if it doesn't exist
		  $connection = Yii::app()->db;
		  $command = $connection->createCommand("CREATE TABLE IF NOT EXISTS `audits` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) NOT NULL,
			  `category_id` int(11) NOT NULL,
			  `description` text,
			  `questions` longtext,
			  `creator_id` int(11) DEFAULT NULL,
			  `firm_id` int(11) DEFAULT NULL,
			  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`),
			  KEY `category_id` (`category_id`),
			  KEY `creator_id` (`creator_id`),
			  KEY `firm_id` (`firm_id`)
		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		  $command->execute();

		  // Initialize model data
		  $model = array(
			  'name' => '',
			  'category_id' => '',
			  'description' => '',
			  'questions' => '[]'
		  );
		  $isEdit = false;
		  $editId = null;
		  $questions = '[]';

		  // Get current user's firm ID
		  $currentUserFirmId = null;
		  $currentUserId = Yii::app()->user->id;
		  
		  if ($currentUserId) {
			  $userData = Yii::app()->db->createCommand()
				  ->select('firmid')
				  ->from('user')
				  ->where('id=:id', array(':id'=>$currentUserId))
				  ->queryRow();
			  
			  if ($userData && isset($userData['firmid'])) {
				  $currentUserFirmId = $userData['firmid'];
			  }
		  }

		  // Handle editing
		  if(isset($_GET['edit'])) {
			  $editId = (int)$_GET['edit'];
			  $auditData = Yii::app()->db->createCommand()
				  ->select('*')
				  ->from('audits')
				  ->where('id=:id AND firm_id=:firm_id', array(':id'=>$editId, ':firm_id'=>$currentUserFirmId))
				  ->queryRow();
			  
			  if($auditData) {
				  $model['name'] = $auditData['name'];
				  $model['category_id'] = $auditData['category_id'];
				  $model['description'] = $auditData['description'];
				  
				  // Make sure questions is valid JSON
				  if (is_string($auditData['questions'])) {
					  // Check if it's already JSON
					  $decoded = json_decode($auditData['questions'], true);
					  if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
						  // Not valid JSON, convert to empty array
						  $questions = '[]';
					  } else {
						  // Already valid JSON, use as is
						  $questions = $auditData['questions'];
					  }
				  } else {
					  // Not a string, encode as JSON
					  $questions = '[]';
				  }
				  
				  $isEdit = true;
			  }
		  }
		  
		  // Handle form submission
		  if(isset($_POST['name']) && isset($_POST['category_id'])) {
			  $name = $_POST['name'];
			  $categoryId = $_POST['category_id'];
			  $description = isset($_POST['description']) ? $_POST['description'] : '';
			  $questionsJson = isset($_POST['questions']) ? $_POST['questions'] : '[]';
			  
			  if($isEdit) {
				  // Update existing audit
				  $command = Yii::app()->db->createCommand();
				  $command->update('audits', array(
					  'name' => $name,
					  'category_id' => $categoryId,
					  'description' => $description,
					  'questions' => $questionsJson
				  ), 'id=:id AND firm_id=:firm_id', array(':id'=>$editId, ':firm_id'=>$currentUserFirmId));
				  
				  Yii::app()->user->setFlash('success', 'Audit updated successfully');
				  
						  // Redirect to the separate audit edit page
				  $this->redirect(array('auditsedit', 'edit'=>$editId));
			  } else {
				  // Create new audit
				  $command = Yii::app()->db->createCommand();
				  $command->insert('audits', array(
					  'name' => $name,
					  'category_id' => $categoryId,
					  'description' => $description,
					  'questions' => $questionsJson,
					  'creator_id' => $currentUserId,
					  'firm_id' => $currentUserFirmId
				  ));
				  
				  Yii::app()->user->setFlash('success', 'Audit created successfully');
				  
				  // For new audits, go back to the main audit list
				  $this->redirect(array('audits'));
			  }
		  }

		  // Handle audit copy
		  if(isset($_GET['copy'])) {
			  $auditId = (int)$_GET['copy'];
			  
			  // Get the audit to copy
			  $auditData = Yii::app()->db->createCommand()
				  ->select('*')
				  ->from('audits')
				  ->where('id=:id AND firm_id=:firm_id', array(':id'=>$auditId, ':firm_id'=>$currentUserFirmId))
				  ->queryRow();
			  
			  if($auditData) {
				  // Create a new audit as a copy
				  $command = Yii::app()->db->createCommand();
				  $newAuditData = array(
					  'name' => $auditData['name'] . ' - Copy',
					  'category_id' => $auditData['category_id'],
					  'description' => $auditData['description'],
					  'questions' => $auditData['questions'],
					  'creator_id' => $currentUserId,
					  'firm_id' => $currentUserFirmId
				  );
				  
				  $command->insert('audits', $newAuditData);
				  $newAuditId = Yii::app()->db->getLastInsertID();
				  
				  Yii::app()->user->setFlash('success', 'Audit copied successfully');
				  
				  // Redirect to edit the new copy
				  $this->redirect(array('auditsedit', 'edit'=>$newAuditId));
			  } else {
				  Yii::app()->user->setFlash('error', 'Audit not found or you do not have permission to copy it');
				  $this->redirect(array('audits'));
			  }
		  }
		  
		  // Handle audit deletion
		  if(isset($_GET['delete'])) {
			  $auditId = (int)$_GET['delete'];
			  
			  // Delete the audit
			  $command = Yii::app()->db->createCommand();
			  $command->delete('audits', 'id=:id AND firm_id=:firm_id', array(':id'=>$auditId, ':firm_id'=>$currentUserFirmId));
			  
			  Yii::app()->user->setFlash('success', 'Audit deleted successfully');
			  $this->redirect(array('audits'));
		  }

		  // Get all audits for the current firm
		  $audits = Yii::app()->db->createCommand()
			  ->select('a.*, c.name as category_name, u.username as creator_name')
			  ->from('audits a')
			  ->leftJoin('audit_categories c', 'a.category_id = c.id')
			  ->leftJoin('user u', 'a.creator_id = u.id')
			  ->where('a.firm_id=:firm_id', array(':firm_id'=>$currentUserFirmId))
			  ->order('a.name ASC')
			  ->queryAll();
		  
		  // Calculate the number of questions for each audit and prepare questions preview
		  foreach ($audits as &$audit) {
			  $questionCount = 0;
			  $questionsPreview = array();
			  
			  if (!empty($audit['questions'])) {
				  $questionsData = json_decode($audit['questions'], true);
				  
				  // Check if we have the new format with headers and questions
				  if (is_array($questionsData) && isset($questionsData['headers']) && isset($questionsData['questions'])) {
					  // New format - count only actual questions
					  $questionCount = count($questionsData['questions']);
					  
					  // Instead of flattening the structure, keep the original structure for the preview
					  // This will allow the JavaScript to properly organize questions under their headers
					  $questionsPreview = array(
						  'headers' => array(),
						  'questions' => array()
					  );
					  
					  // Add all headers (limited to first 5 for preview)
					  $previewHeaders = array_slice($questionsData['headers'], 0, 5);
					  foreach ($previewHeaders as $header) {
						  $questionsPreview['headers'][] = array(
							  'id' => $header['id'],
							  'text' => strlen($header['text']) > 50 ? substr($header['text'], 0, 50) . '...' : $header['text']
						  );
					  }
					  
					  // Add questions (limited to first 15 for preview)
					  $previewQuestionsData = array_slice($questionsData['questions'], 0, 15);
					  foreach ($previewQuestionsData as $question) {
						  $questionsPreview['questions'][] = array(
							  'text' => strlen($question['text']) > 50 ? substr($question['text'], 0, 50) . '...' : $question['text'],
							  'weight' => isset($question['weight']) ? $question['weight'] : 1,
							  'headerId' => isset($question['headerId']) ? $question['headerId'] : null
						  );
					  }
					  
					  // Use the structured data directly
					  $previewQuestions = $questionsPreview;
				  } else {
					  // Old format - filter out headers
					  $actualQuestions = array_filter($questionsData, function($q) {
						  return !(isset($q['isHeader']) && $q['isHeader']) && !(isset($q['type']) && $q['type'] === 'header');
					  });
					  
					  $questionCount = count($actualQuestions);
					  
					  // Get the first 10 questions for preview
					  $previewQuestions = array_slice($questionsData, 0, 10);
				  }
				  
				  // Prepare preview data
				  foreach ($previewQuestions as $q) {
					  // Truncate question text if too long
					  $text = isset($q['text']) ? $q['text'] : '';
					  
					  if (strlen($text) > 50) {
						  $text = substr($text, 0, 50) . '...';
					  }
					  
					  $previewItem = array(
						  'text' => $text,
						  'isHeader' => isset($q['isHeader']) && $q['isHeader'] ? true : (isset($q['type']) && $q['type'] === 'header' ? true : false)
					  );
					  
					  // Add weight for non-headers
					  if (!$previewItem['isHeader']) {
						  $previewItem['weight'] = isset($q['weight']) ? $q['weight'] : 1;
					  }
					  
					  $questionsPreview[] = $previewItem;
				  }
				  
				  // Make sure we have the correct count
				  if ($questionCount === 0 && !empty($questionsData)) {
					  // Fallback to counting all items if we couldn't determine actual questions
					  $questionCount = count($questionsData);
				  }
			  }
			  
			  $audit['question_count'] = $questionCount;
			  $audit['questions_preview'] = json_encode($questionsPreview);
		  }
		  
		  // Get categories for dropdown
		  $categoryDropdown = $this->getCategoriesForDropdown();

		  // If edit parameter is present, redirect to the separate edit page
		  if(isset($_GET['edit'])) {
			  $this->redirect(array('auditsedit', 'edit' => $_GET['edit']));
			  return;
		  }

		  $this->render('audits', array(
			  'model' => $model,
			  'audits' => $audits,
			  'categoryDropdown' => $categoryDropdown,
			  'isEdit' => $isEdit,
			  'editId' => $editId,
			  'questions' => $questions
		  ));
	 }
	 public function actionAuditsEdit()
	 {
		  // Create the audits table if it doesn't exist
		  $connection = Yii::app()->db;
		  $command = $connection->createCommand("CREATE TABLE IF NOT EXISTS `audits` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) NOT NULL,
			  `category_id` int(11) DEFAULT NULL,
			  `description` text,
			  `questions` text,
			  `creator_id` int(11) DEFAULT NULL,
			  `firm_id` int(11) DEFAULT NULL,
			  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`),
			  KEY `category_id` (`category_id`),
			  KEY `creator_id` (`creator_id`),
			  KEY `firm_id` (`firm_id`)
		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		  $command->execute();

		  // Initialize model data
		  $model = array(
			  'name' => '',
			  'category_id' => '',
			  'description' => '',
			  'questions' => '[]'
		  );
		  $editId = null;
		  $questions = '[]';

		  // Get current user's firm ID
		  $currentUserFirmId = null;
		  $currentUserId = Yii::app()->user->id;
		  
		  if ($currentUserId) {
			  $userData = Yii::app()->db->createCommand()
				  ->select('firmid')
				  ->from('user')
				  ->where('id=:id', array(':id'=>$currentUserId))
				  ->queryRow();
			  
			  if ($userData && isset($userData['firmid'])) {
				  $currentUserFirmId = $userData['firmid'];
			  }
		  }

		  // Handle editing
		  if(isset($_GET['edit'])) {
			  $editId = (int)$_GET['edit'];
			  $auditData = Yii::app()->db->createCommand()
				  ->select('*')
				  ->from('audits')
				  ->where('id=:id AND firm_id=:firm_id', array(':id'=>$editId, ':firm_id'=>$currentUserFirmId))
				  ->queryRow();
			  
			  if($auditData) {
				  $model['name'] = $auditData['name'];
				  $model['category_id'] = $auditData['category_id'];
				  $model['description'] = $auditData['description'];
				  
				  // Make sure questions is valid JSON
				  if (is_string($auditData['questions'])) {
					  // Check if it's already JSON
					  $decoded = json_decode($auditData['questions'], true);
					  if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
						  // Not valid JSON, convert to empty array
						  $questions = '[]';
					  } else {
						  // Already valid JSON, use as is
						  $questions = $auditData['questions'];
					  }
				  } else {
					  // Not a string, encode as JSON
					  $questions = '[]';
				  }
			  } else {
				  // Audit not found or user doesn't have permission
				  Yii::app()->user->setFlash('error', 'Audit not found or you do not have permission to edit it');
				  $this->redirect(array('audits'));
				  return;
			  }
		  } else {
			  // No edit parameter provided
			  $this->redirect(array('audits'));
			  return;
		  }
		  
		  // Handle form submission
		  if(isset($_POST['name']) && isset($_POST['category_id'])) {
			  $name = $_POST['name'];
			  $categoryId = $_POST['category_id'];
			  $description = isset($_POST['description']) ? $_POST['description'] : '';
			  $questionsJson = isset($_POST['questions']) ? $_POST['questions'] : '[]';
			  
			  // Update existing audit
			  $command = Yii::app()->db->createCommand();
			  $command->update('audits', array(
				  'name' => $name,
				  'category_id' => $categoryId,
				  'description' => $description,
				  'questions' => $questionsJson
			  ), 'id=:id AND firm_id=:firm_id', array(':id'=>$editId, ':firm_id'=>$currentUserFirmId));
			  
			  Yii::app()->user->setFlash('success', 'Audit updated successfully');
			  
			  // Stay on the same edit page
			  $this->redirect(array('auditsedit', 'edit'=>$editId));
		  }

		  // Get categories for dropdown
		  $categoryDropdown = $this->getCategoriesForDropdown();

		  $this->render('auditsedit', array(
			  'model' => $model,
			  'categoryDropdown' => $categoryDropdown,
			  'editId' => $editId,
			  'questions' => $questions
		  ));
	 }

	public function actionAuditcategories()
	 {
		  // Create the table if it doesn't exist
		  $connection = Yii::app()->db;
		  $command = $connection->createCommand("CREATE TABLE IF NOT EXISTS `audit_categories` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) NOT NULL,
			  `description` text,
			  `parent_id` int(11) DEFAULT NULL,
			  `creator_id` int(11) DEFAULT NULL,
			  `firm_id` int(11) DEFAULT NULL,
			  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`),
			  KEY `parent_id` (`parent_id`),
			  KEY `creator_id` (`creator_id`),
			  KEY `firm_id` (`firm_id`)
		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		  $command->execute();
		  
		  // Add creator_id and firm_id columns if they don't exist
		  $tableSchema = $connection->schema->getTable('audit_categories');
		  if ($tableSchema) {
			  if (!isset($tableSchema->columns['creator_id'])) {
				  $connection->createCommand("ALTER TABLE `audit_categories` ADD COLUMN `creator_id` int(11) DEFAULT NULL AFTER `parent_id`, ADD INDEX `creator_id` (`creator_id`);")->execute();
			  }
			  if (!isset($tableSchema->columns['firm_id'])) {
				  $connection->createCommand("ALTER TABLE `audit_categories` ADD COLUMN `firm_id` int(11) DEFAULT NULL AFTER `creator_id`, ADD INDEX `firm_id` (`firm_id`);")->execute();
			  }
		  }

		  // Initialize model data
		  $model = array(
			  'name' => '',
			  'description' => '',
			  'parent_id' => ''
		  );
		  $isEdit = false;
		  $editId = null;

		  // Handle editing
		  if(isset($_GET['edit'])) {
			  $editId = (int)$_GET['edit'];
			  $categoryData = Yii::app()->db->createCommand()
				  ->select('*')
				  ->from('audit_categories')
				  ->where('id=:id', array(':id'=>$editId))
				  ->queryRow();
			  
			  if($categoryData) {
				  $model['name'] = $categoryData['name'];
				  $model['description'] = $categoryData['description'];
				  $model['parent_id'] = $categoryData['parent_id'];
				  $isEdit = true;
			  }
		  }
		  
		  // Handle form submission
		  if(isset($_POST['name'])) {
			  $name = $_POST['name'];
			  $description = isset($_POST['description']) ? $_POST['description'] : '';
			  $parentId = isset($_POST['parent_id']) && !empty($_POST['parent_id']) ? $_POST['parent_id'] : null;
			  
			  // Check if the selected parent is already a subcategory (has a parent)
			  if ($parentId) {
				  $parentCategory = Yii::app()->db->createCommand()
					  ->select('parent_id')
					  ->from('audit_categories')
					  ->where('id=:id', array(':id'=>$parentId))
					  ->queryRow();
				  
				  if ($parentCategory && $parentCategory['parent_id'] !== null) {
					  // The selected parent is already a subcategory, so we can't create a category under it
					  Yii::app()->user->setFlash('error', 'Cannot create a third-level category. Only two levels (main category and subcategory) are allowed.');
					  $this->redirect(array('auditcategories'));
					  return;
				  }
			  }
			  
			  // Get current user ID and firm ID
			  $creatorId = Yii::app()->user->id;
			  $firmId = null;
			  
			  // Get user's firm ID from the user table
			  if ($creatorId) {
				  $userData = Yii::app()->db->createCommand()
					  ->select('firmid')
					  ->from('user')
					  ->where('id=:id', array(':id'=>$creatorId))
					  ->queryRow();
				  
				  if ($userData && isset($userData['firmid'])) {
					  $firmId = $userData['firmid'];
				  }
			  }
			  
			  if($isEdit) {
				  // Update existing category
				  $command = Yii::app()->db->createCommand();
				  $command->update('audit_categories', array(
					  'name' => $name,
					  'description' => $description,
					  'parent_id' => $parentId,
				  ), 'id=:id', array(':id'=>$editId));
				  
				  Yii::app()->user->setFlash('success', 'Category updated successfully');
			  } else {
				  // Create new category
				  $command = Yii::app()->db->createCommand();
				  $command->insert('audit_categories', array(
					  'name' => $name,
					  'description' => $description,
					  'parent_id' => $parentId,
					  'creator_id' => $creatorId,
					  'firm_id' => $firmId,
				  ));
				  
				  Yii::app()->user->setFlash('success', 'Category created successfully');
			  }
			  
			  $this->redirect(array('auditcategories'));
		  }

		  // Handle category deletion
		  if(isset($_GET['delete'])) {
			  $categoryId = (int)$_GET['delete'];
			  
			  // First delete child categories
			  $command = Yii::app()->db->createCommand();
			  $command->delete('audit_categories', 'parent_id=:parent_id', array(':parent_id'=>$categoryId));
			  
			  // Then delete the category itself
			  $command = Yii::app()->db->createCommand();
			  $command->delete('audit_categories', 'id=:id', array(':id'=>$categoryId));
			  
			  Yii::app()->user->setFlash('success', 'Category deleted successfully');
			  $this->redirect(array('auditcategories'));
		  }

		  // Get all categories for the tree view
		  $categories = $this->getCategoryTree();
		  
		  // Get categories for dropdown
		  $categoryDropdown = $this->getCategoriesForDropdown();

		  $this->render('auditcategories', array(
			  'model' => $model,
			  'categories' => $categories,
			  'categoryDropdown' => $categoryDropdown,
			  'isEdit' => $isEdit,
			  'editId' => $editId,
		  ));
	 }

	/**
	 * Get all categories as a hierarchical array
	 * @param int $parentId Parent category ID
	 * @return array
	 */
	public function getCategoryTree($parentId = null)
	{
		// Get current user's firm ID
		$currentUserFirmId = null;
		$currentUserId = Yii::app()->user->id;
		
		if ($currentUserId) {
			$userData = Yii::app()->db->createCommand()
				->select('firmid')
				->from('user')
				->where('id=:id', array(':id'=>$currentUserId))
				->queryRow();
			
			if ($userData && isset($userData['firmid'])) {
				$currentUserFirmId = $userData['firmid'];
			}
		}
		
		// Build the SQL query with firm_id filter
		$sql = "SELECT c.*, u.username as creator_name, f.name as firm_name 
			FROM audit_categories c 
			LEFT JOIN user u ON c.creator_id = u.id 
			LEFT JOIN firm f ON c.firm_id = f.id 
			WHERE c.parent_id " . 
			($parentId === null ? "IS NULL" : "= $parentId");
		
		// Add firm_id filter if we have a firm ID
		if ($currentUserFirmId) {
			$sql .= " AND c.firm_id = $currentUserFirmId";
		}
		
		$sql .= " ORDER BY c.name ASC";
		$categories = Yii::app()->db->createCommand($sql)->queryAll();
		
		$result = array();
		
		foreach ($categories as $category) {
			$node = array(
				'id' => $category['id'],
				'name' => $category['name'],
				'description' => $category['description'],
				'creator_id' => $category['creator_id'],
				'creator_name' => $category['creator_name'],
				'firm_id' => $category['firm_id'],
				'firm_name' => $category['firm_name'],
				'created_at' => $category['created_at'],
				'children' => $this->getCategoryTree($category['id'])
			);
			$result[] = $node;
		}
		
		return $result;
	}

	/**
	 * Get categories as a hierarchical array for dropdowns
	 * @param bool $onlyMainCategories If true, only returns main categories (no parent)
	 * @return array
	 */
	public function getCategoriesForDropdown($onlyMainCategories = false)
	{
		// Get current user's firm ID
		$currentUserFirmId = null;
		$currentUserId = Yii::app()->user->id;
		
		if ($currentUserId) {
			$userData = Yii::app()->db->createCommand()
				->select('firmid')
				->from('user')
				->where('id=:id', array(':id'=>$currentUserId))
				->queryRow();
			
			if ($userData && isset($userData['firmid'])) {
				$currentUserFirmId = $userData['firmid'];
			}
		}
		
		// First get all categories for the current firm
		$firmFilter = $currentUserFirmId ? "WHERE firm_id = $currentUserFirmId" : "";
		$allCategories = Yii::app()->db->createCommand("SELECT id, name, parent_id FROM audit_categories $firmFilter ORDER BY name ASC")->queryAll();
		
		// Find parent categories (categories that have children)
		$parentCategories = array();
		$categoryChildren = array();
		
		// First pass: identify parent categories and build parent-child relationships
		foreach ($allCategories as $category) {
			// If this category has a parent, add it to that parent's children list
			if (!empty($category['parent_id'])) {
				if (!isset($categoryChildren[$category['parent_id']])) {
					$categoryChildren[$category['parent_id']] = array();
				}
				$categoryChildren[$category['parent_id']][] = $category;
				$parentCategories[$category['parent_id']] = true;
			}
		}
		
		// Build the result array with hierarchical structure
		$result = array('' => 'No Parent (Root Category)');
		
		// Get main categories (those with no parent or parent_id = 0)
		$mainCategories = array_filter($allCategories, function($cat) {
			return $cat['parent_id'] === null || $cat['parent_id'] == 0;
		});
		
		// Sort main categories by name
		usort($mainCategories, function($a, $b) {
			return strcmp($a['name'], $b['name']);
		});
		
		// Add main categories to result
		foreach ($mainCategories as $mainCategory) {
			$isParent = isset($parentCategories[$mainCategory['id']]);
			$result[$mainCategory['id']] = array(
				'name' => $mainCategory['name'],
				'is_parent' => $isParent,
				'parent_id' => null
			);
			
			// If not in onlyMainCategories mode and this category has children, add them
			if (!$onlyMainCategories && $isParent && isset($categoryChildren[$mainCategory['id']])) {
				// Sort children by name
				usort($categoryChildren[$mainCategory['id']], function($a, $b) {
					return strcmp($a['name'], $b['name']);
				});
				
				foreach ($categoryChildren[$mainCategory['id']] as $childCategory) {
					$isChildParent = isset($parentCategories[$childCategory['id']]);
					$result[$childCategory['id']] = array(
						'name' => '— ' . $childCategory['name'], // Add indentation to show hierarchy
						'is_parent' => $isChildParent,
						'parent_id' => $mainCategory['id']
					);
				}
			}
		}
		
		return $result;
	}

	public function isactiveuser()  //user,firma-branch-client-client branch aktifmi diye bakar
	{


		$user=User::model()->findbypk(Yii::app()->user->id);

		$isactive=1;
	

		if($user && intval($user->active)==1)
		{
			if($user->firmid>0)
			{
				$firm=Firm::model()->findbypk($user->firmid);
				if($firm->active==0)
				{
					$isactive=0;
				}
			}

			if($isactive==1)
			{
			if($user->mainbranchid>0 || $user->branchid>0)
			{
				$firm=Firm::model()->findbypk($user->mainbranchid);
				if($firm->active==0)
				{
					$isactive=0;
				}

				if($isactive==0)
				{
					$firm=Firm::model()->findbypk($user->branchid);
					if($firm->active==0)
					{
						$isactive=0;
					}
					else
					{
						$isactive=1;

					}
				}

			}
		}

			if($user->clientid>0)
			{

				$firm=Client::model()->findbypk($user->clientid);
				if($firm->active==0)
				{

					$isactive=0;
				}
			}


			if($user->clientbranchid>0)
			{
				$firm=Client::model()->findbypk($user->mainclientbranchid);
				if($firm->active==0)
				{
					$isactive=0;
				}


				if($isactive==0)
				{
					$firm=Client::model()->findbypk($user->clientbranchid);
					if($firm->active==0)
					{
						$isactive=0;
					}
					else
					{
						$isactive=1;

					}
				}

			}


		// else
		// {
		// 	$isactive=0;
		// }
	}else{
      $isactive=0;
    }




		if($isactive==0)
		{

        Yii::app()->user->logout();
		//	Yii::app()->user->setFlash('error',t('Your membership is closed'));
				//Yii::app()->SetFlashes->add($model,t('Your membership is closed'),array('login'));
				
		
		}


	}


	public function actionIndex()
	{
    if(isset($_GET['r']) && $_GET['r']=='site/issimport') 
    {
      $return= Client::model()->issimport();
      echo 'okkk!';exit;
    }

		$this->isactiveuser();

       if (Yii::app()->user->isGuest)
		   {
		      //Yii::app()->user->setFlash('error',t('Your membership has been disabled. Please contact the authorities for information!'));

				$this->redirect(Yii::app()->createUrl('site/login'));
		   }
	   else
		   {
				if (isset($_GET['changemode']))
				{  ///?changemode=Package1.SafranÇevre1.Admin
					User::model()->setauthdefault($_GET['changemode']);
				}else{

				}
		   }
		   $ax= User::model()->userobjecty('');

		 	if(isset($_GET['ismaintenance']))
		 {

		  $systeminmaintenance=Systeminmaintenance::model()->find(array('condition'=>'id=1'));

    	    if(isset($_GET['ismaintenance']) && $_GET['ismaintenance']==0)
    	    {
    	        $systeminmaintenance->ismaintenance=0;

    	        Yii::app()->user->setFlash('pages/indexclient','Sistem Bakımdan çıkarıldı');
    	    }

    	     if(isset($_GET['ismaintenance']) && $_GET['ismaintenance']==1)
    	    {
    	         $systeminmaintenance->ismaintenance=1;

    	         Yii::app()->user->setFlash('pages/indexclient','Sistem Bakımdan alındı');
    	    }
	        $systeminmaintenance->createdtime=time();
	        $systeminmaintenance->save();
		 }
		  $systeminmaintenance=Systeminmaintenance::model()->find(array('condition'=>'id=1'));
		 if($systeminmaintenance->ismaintenance==1 && $ax->id!=1)
		 {
		      $this->redirect(Yii::app()->createUrl('site/login?site=bakimda'));
		 }








		   $user=User::model()->findbypk(Yii::app()->user->id);

		   if($user->mainbranchid!=$user->branchid && $user->branchid==$user->clientid)
		   {

		       $user->branchid=$user->mainbranchid;
		       $user->save();
		   }
		   if ($user->clientid<>0){
			 $this->render('pages/indexclient');
		   }else
		{
			 $this->render('pages/indexfirm');
			 //$this->render('index');
		}
	}

  
  public function actionGecistren()
  {
    
    
		$this->render('gecistren');
    
  }
  
  
	public function GetIP(){
 if(getenv("HTTP_CLIENT_IP")) {
 $ip = getenv("HTTP_CLIENT_IP");
 } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
 $ip = getenv("HTTP_X_FORWARDED_FOR");
 if (strstr($ip, ',')) {
 $tmp = explode (',', $ip);
 $ip = trim($tmp[0]);
 }
 } else {
 $ip = getenv("REMOTE_ADDR");
 }
 return $ip;
}

	public function actionQuality()
	{
         $this->render('quality');
	}

	public function actionNewqr()
	{
		$QRs=array();
		$count=$_POST["adet"];
		for ($i=1;$i<=$count;$i++){


			$output=time()+rand(0,999999)+round(microtime(true) * 1000);
			$model=Monitoring::model()->findAll(array('condition'=>'barcodeno='.$output));
			if($model){}else{

				if(!in_array($output,$QRs))
				{
					array_push($QRs,$output);
				}

			}


		}
		include("./barcode/newBarcodelist.php");

	}

	public function actionCreatenewqr(){

		$this->render('createnewqr');
	}


	public function actionWorkorder()
	{
         $this->render('workorder');
	}

	public function actionReports()
	{
         $this->render('reports');
	}


	public function actionDetail()
	{

		 $this->render('detail');
	}

	public function actionConformitydeadline()
	{

		 $this->render('conformitydeadline');
	}

	public function actionCloseopenconformity()
	{
		$this->render('closeopenconformity');
	}


	public function actionFindingscu()
	{
		 $ax= User::model()->userobjecty('');
		$path=Yii::getPathOfAlias('webroot').'/uploads';
		$temTime=time();
		
		if(intval($_POST['id'])==0)
		{
			$model=new Findings();
		}
		else
		{
			$model=Findings::model()->find(array('condition'=>'id='.intval($_POST['id'])));
		}


	    $image=CUploadedFile::getInstance($model,'picture_url');


		if(isset($image))
		{
			$type=explode('.',$image->name);
			$time=time();
			$image->saveas($path.'/'.$temTime.'logo.'.$type[1].$time);
			if($model->picture_url!='')
			{
				$filepath=Yii::getPathOfAlias('webroot').'/'.$model->picture_url;
				unlink($filepath);
			}
			$model->picture_url=Yii::app()->baseUrl.'/'.'uploads/'.$temTime.'logo.'.$type[1].$time;
		}
		$model->note=$_POST['Findings']['note'];
		$model->workorder_id=$_POST['reportno'];
		$model->created_time=time();
		$model->file_size=0;
		$model->saver_id=$ax->id;
		$model->unique_id=Findings::model()->isencrypt($_POST['reportno'],'',8);
		$username=Firm::model()->usernameproduce($_POST['Firm']['name']);
		
		
		if($model->save())
		{
			echo 1;
			exit;
		}
		echo 0;
		exit;
	}
	
	public function actionFindingdelete()
	{
		$ax= User::model()->userobjecty('');
		$path=Yii::getPathOfAlias('webroot').'/uploads';
		$model=Findings::model()->find(array('condition'=>'id='.intval($_POST['Finding']['id'])));
		  if ($model) {
			if($model->picture_url!='' && strpos($model->picture_url, 'uploads')!==false)
				{
					$filepath=Yii::getPathOfAlias('webroot').'/'.$model->picture_url;
        if (file_exists($filepath))		unlink($filepath);
			
				}
			 // Modeli sil
			if($model->delete())
			{
				echo 1;
				exit;
			}
			echo 0;
			exit;
		}
		echo 2;
		exit;
			
	}
	
	public function actionFindingList()
	{
		$workorderid=$_GET['workorderid'];
		$reportno=$_GET['reportno'];
		
							$findings=  Findings::model()->findAll(array("condition"=>"workorder_id=".$workorderid, 'order'=>'id asc'));
							
							$htmlconfedit='';

						$say=0;
						foreach($findings as $uygunsuzluk)
						{
							
							$htmlconfedit.='	
							<div class="col-xl-6 col-lg-6 col-md-6 mb-1">
							<input type="hidden" name="id" id="id_'.$uygunsuzluk->id.'" class="form-control" value="'.$uygunsuzluk->id.'">
							<input type="hidden" name="workorderid" id="workorderid_'.$uygunsuzluk->id.'" class="form-control" value="'.$workorderid.'">
							<input id="reportno_'.$uygunsuzluk->id.'" type="hidden" name="reportno" class="form-control" value="'.$reportno.'">
																		
							<div class=" findings-s" align="center">	<center><img class="img-responsive" src="'.$uygunsuzluk->picture_url.'"  style="background: white; max-height:145px;  width:100%;"></center>
										<br>';
										// <div class="col-xl-12 col-lg-12 col-md-12">
																// <label for="basicSelect" class="label-left">'.t('Image').'</label>
																// <fieldset class="form-group">
																	// <input type="file" id="picture_url_'.$uygunsuzluk->id.'" name="Findings[picture_url]" class="form-control" placeholder="'.t('Image').'" value="'.$uygunsuzluk->picture_url.'">
																// </fieldset>
															// </div>
															
															
									$htmlconfedit.='	<div class="col-xl-12 col-lg-12 col-md-12">
																<label for="basicSelect" class="label-left">'.t('Note').'</label>
																<fieldset class="form-group">
																
																	<textarea rows="7" id="note_'.$uygunsuzluk->id.'" type="text" name="Findings[note]" class="form-control" placeholder="'.t('Note').'">'.strip_tags($uygunsuzluk->note).'</textarea>
															
																</fieldset>
															</div>
										<div class="col-xl-12 col-lg-12 col-md-12">
																<a class="btn btn-danger btn-sm" onclick="findingdelete('.$uygunsuzluk->id.')">Delete</a>
																<a class="btn btn-warning btn-sm"  onclick="findingupdate('.$uygunsuzluk->id.')">Update</a>
															</div>
															
										</div>
									
										</div>

							';
						}
						
						echo $htmlconfedit;
						exit;
						

			
	}
	

public function actionServicereportupdate()
	{
		$id=$_POST['id'];
		$reportno=$_POST['reportno'];
		$trade_name=$_POST['trade_name'];
		$treatment_and_observations=nl2br($_POST['treatment_and_observations']);
		$housekeeping=nl2br($_POST['housekeeping']);
		$proofing=nl2br($_POST['proofing']);
		$model=Servicereport::model()->findbypk($id);
		$model->trade_name=$trade_name;
		$model->treatment_and_observations=$treatment_and_observations;
		$model->housekeeping=$housekeeping;
		$model->proofing=$proofing;
		$model->save();
		// $firm=Firm::model()->find(array("condition"=>"id=".$workorders[0]['firmid']));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		 Yii::app()->SetFlashes->add($model,t('Update Success!'),array('servicereport4?id='.$id.'&languageok=en&pdf=ok'));
	}
	public function actionReportssearch()
	{
		$firmid=$_POST['Reports']['firmid'];
		$branchid=$_POST['Reports']['branchid'];
		$team=$_POST['Reports']['team'];
		$staff=Workorder::model()->msplit($_POST['Reports']['staff']);
		$routeid=$_POST['Reports']['routeid'];
		$clientid=$_POST['Reports']['clientid'];
		$visittypeid=$_POST['Reports']['visittypeid'];
		$startdate=$_POST['Reports']['startdate'];
		$finishdate=$_POST['Reports']['finishdate'];


     Yii::app()->SetFlashes->add($model,t('Raport Search Success!'),array('reports?firm='.$firmid.'&&branch='.$branchid.'&&team='.$team.'&&staff='.$staff.'&&route='.$routeid.'&&client='.$clientid.'&&visittype='.$visittypeid.'&&sdate='.$startdate.'&&fdate='.$finishdate));

}



	/**
	 * This is the default 'crudlist' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionCrudlist()
	{

		   $this->render('crudlist');

	}

	public function actionMobile()
	{

		   $this->render('mobile');

	}

	public function actionConformityqrreports(){

		$this->render('conformityqrreports');
	}


	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionNotpages()
	{
		$this->render('notpages');
	}
	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

    public function actionServicereport()
    { 
        if(isset($_POST["client_name"]))
        {
            $model=new Servicereport;

            $model->client_name=$_POST["client_name"];
            $model->date=$_POST["date"];
            $model->reportno=$_POST["reportno"];
            $visittypes = implode($_POST["visittype"], ', ');
            $model->visittype=$visittypes;
            $model->servicedetails=$_POST["servicedetails"];
            $model->trade_name=$_POST["trade_name"];
            $model->active_ingredient=$_POST["active_ingredient"];
            $model->amount_applied=$_POST["amount_applied"];
            $model->riskreview=$_POST["riskreview"];
            if($model->save())
            {
                $this->refresh();
            }
            else
            {
                print_r($model->getErrors());
            }
        }
        $this->render('servicereport');

    }


public function actionServicereport2()
    {
  exit;
  ob_start();
		$workorders = Yii::app()->db->createCommand()
  ->select('sr.*,w.id wid,w.firmid,w.clientid,f.name fname,fb.address,w.realstarttime,w.realendtime,w.executiondate,fb.landphone')
		->from('servicereport sr')
		->leftjoin('workorder w', 'w.id=sr.reportno')
		->leftjoin('firm f', 'f.id=w.firmid')
		->leftjoin('firm fb', 'fb.id=w.branchid')
		->where('sr.id='.$_GET['id'])
		->queryall();
		$firm=Firm::model()->find(array("condition"=>"id=".$workorders[0]['firmid']));
		$url = Yii::app()->basepath."/views/site/";
		 $mpdf=new \Mpdf\Mpdf();
			 include($url . "servicereport2.php");
			 //$mpdf = new mpdf();
			 $mpdf->curlAllowUnsafeSslRequests = true;
			// $mpdf->showImageErrors = true;
             $mpdf->WriteHTML($html);
			 //$mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');
			  $mpdf->SetHTMLFooter('<img src="'.Yii::app()->baseUrl.'/'.$firm->image_footer.'"/>');
			  

  $dosyaname=str_replace("/"," - ",$workorders[0]['client_name']).'-'.date('m-d-Y', $workorders[0]['date']).'_'.$_GET['id'].'_Service_Report.pdf';
 
 if(file_exists(Yii::app()->basepath."/../uploads/".$dosyaname))
				{
				unlink(Yii::app()->basepath."/../uploads/".$dosyaname);

				}
			//	print_r($workorders[0]);
             $mpdf->Output(Yii::app()->basepath."/../uploads/".$dosyaname,'F');
			 
  $senderemail='oneri.uygunsuzluk@insectram.io';
  $sendername='Insectram Servis Formu';
  $subject=$workorders[0]['client_name'].' - '.$workorders[0]['reportno'].' Nolu Servis Formu';
  $altbody='Oluşturulan Servis Formu ekteki gibidir.';
  $msg='Oluşturulan Servis Formu ekteki gibidir.';


  $pdf=Yii::app()->basepath."/../uploads/".'service_raport_'.$_GET['id'].'.pdf';
  $pdf=Yii::app()->basepath."/../uploads/".$dosyaname;
  
  $client_id=$workorders[0]['clientid'];
  $mainclientid=Client::model()->findbypk($client_id)->mainclientid;
			
 
  if (isset($_GET['pdf'])){
     $this->redirect("/uploads/".$dosyaname.'?'.time());

  }else{
     $buyeremail='taylorinsectram@gmail.com';
  Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername,$pdf);
  usleep(300000);
     $cli=User::model()->findAll(array("condition"=>"(clientbranchid=".$client_id." or clientid=".$mainclientid." and clientbranchid=0) and active=1"));
$mlist=[];
  foreach ($cli as $clients){
    
    
      	$serviceemail=Generalsettings::model()->find(array(
								   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'serviceemail','userid'=>$clients->id)
							   ));
			if(isset($serviceemail))
			{
				if ($serviceemail->isactive=='1'){
             
    $buyeremail=$clients->email;
  $mlist[]=$clients->email;
 Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername,$pdf);
  usleep(30000);
        }
			}
			
    
 
  }
    
  
  }
 
           //  Conformity::model()->email('oneri.uygunsuzluk@insectram.io',$workorders[0]['name'].'Servis Formu','Filiz Çürükcü','Servis Formu',$workorders[0]['name'].'Servis Formu','Oluşturulan Servis Formu ekteki gibidir.','alpbarutcu@gmail.com','filiz çürükcü',Yii::app()->basepath."/../uploads/".'service_raport_'.$_GET['id'].'.pdf');
 // echo $veriler2;exit;
      

ob_clean();
  if (count($mlist)==0){
    echo 'Mail gönderilecek Müşteri şube admini maili bulunamadı!';
  }else{
    
echo "Mail ".count($mlist)." kişiye gönderildi:";
  foreach($mlist as $item){
    echo $item.', ';
  }
    
  }
ob_end_flush();
  exit;
    }
	

public function actionServicereport4()
    {  

		
	if (isset($_GET['publish'])){
		if(isset($_GET['publish']) && $_GET['publish']=='1'){
			
    $sr=Servicereport::model()->findByPk($_GET['id']);
			if($sr){
				$sr->is_published=1;
				$sr->save();
			}
		}else{
					
    $sr=Servicereport::model()->findByPk($_GET['id']);
			if($sr){
				$sr->is_published=0;
				$sr->save();
			}
		}
	}
  


  if (isset($_GET['ajaxref'])){
    		
		$url = Yii::app()->basepath."/views/site/";
			 include($url . "servicereport4.php");
    exit;
  }else{
          $this->render('servicereport4');
  }

	
    }
  
  
  
  
public function actionServicereport5()
    {
  
	$langfileurl= dirname(__FILE__).'/protected/modules/translate/languages/en.php';
			if (file_exists($langfileurl)) //dil dosyasını arıyoruz.
			{	//dil dosyası varsa yüklüyoruz.
				include $langfileurl;
			}

  ob_start();
			$workorders = Yii::app()->db->createCommand()
  ->select('sr.*,w.id wid,w.firmid,w.clientid,f.name fname,fb.address,w.realstarttime,w.realendtime,w.executiondate,w.date
  ,fb.landphone,fb.email,cb.address cbadres,IF(w.staffid is null,CONCAT(uts.name," ",uts.surname),CONCAT(u.name," ",u.surname)) teknisyen, CONCAT(ux.name," ",ux.surname) teknisyen_saver')
		->from('servicereport sr')
		->leftjoin('workorder w', 'w.id=sr.reportno')
		->leftjoin('firm f', 'f.id=w.firmid')
		->leftjoin('firm fb', 'fb.id=w.branchid')
		->leftjoin('client cb', 'cb.id=w.clientid')
		->leftjoin('visittype vt', 'vt.id=w.visittypeid')
		->leftjoin('user u', 'u.id=w.staffid')
		->leftjoin('user ux', 'ux.id=sr.saver_id')
		->leftjoin('staffteam st', 'st.id=w.teamstaffid')
		->leftjoin('user uts', 'uts.id=st.leaderid')
		->where('sr.id='.$_GET['id'])
		->queryall();
		$firm=Firm::model()->find(array("condition"=>"id=".$workorders[0]['firmid']));
		
	 if ($workorders[0]['teknisyen_saver']==''){
        $workorders[0]['teknisyen_saver']=  $workorders[0]['teknisyen'];
      }
		

  $basla=strtotime("today", $workorders[0]['realendtime']);
  $bit=strtotime("today", $workorders[0]['realendtime'])+86400;
  $bit2=strtotime("today", $workorders[0]['realendtime'])+(86400*5);

		$uygunsuzluklar= Yii::app()->db->createCommand()
		->select('c.*,cb.name cbname')
		->from('conformity c')
		->leftjoin('client cb', 'cb.id=c.clientid')
		//->where('c.clientid='.$workorders[0]['clientid'].' and c.date>'.$basla.' and c.date<'.$bit.' and c.workorderid='.$workorders[0]['wid'])
		->where('c.clientid='.$workorders[0]['clientid'].' and c.date>'.$basla.' and c.date<'.$bit2.' and c.workorderid='.$workorders[0]['wid'])
		->order('c.numberid asc')
		->limit(50)
		->queryall();
		
    $findings=  Findings::model()->findAll(array("condition"=>"workorder_id=".$workorders[0]['wid'], 'order'=>'id asc'));

		
  
		$acikiemirleri = Yii::app()->db->createCommand()
		->select('w.*,cb.name cbname,IF(w.statusid=0,"Askıda",IF(w.statusid=5,"Görüldü","Devam Ediyor")) status')
		->from('conformity w')
		->leftjoin('client cb', 'cb.id=w.clientid')
		->where('w.clientid='.$workorders[0]['clientid'].' and w.statusid in (4,5,0) and w.date<'.$bit.' and w.workorderid<>'.$workorders[0]['wid'])
		->queryall();
  
		$stokKimyasalmodelx = Yii::app()->db->createCommand()
		->select('*')
		->from('activeingredients')
		->where('workorderid='.$workorders[0]['reportno'])
		->queryall();


		
		
		
		$mobileworkordermonitorsview = Yii::app()->db->createCommand()
		->select('count(mtv.id) toplam,mt.name,mtv.*')
		->from('mobileworkordermonitors_view mtv')
		->leftjoin('monitoringtype mt', 'mt.id=mtv.monitortype')
		->where('mtv.workorderid='.$workorders[0]['wid'])
		->group('mtv.monitortype')
		->queryall();
		
		$url = Yii::app()->basepath."/views/site/";
		 $mpdf=new \Mpdf\Mpdf(); 
			 include($url . "servicereport5.php");

  ?>
<div style="max-width:75%; margin-left:auto; margin-right:auto;">
  <? // echo $html; 
  ?>
</div>
<?php
     
			//exit;
			 //$mpdf = new mpdf();
			 $mpdf->curlAllowUnsafeSslRequests = true;
			// $mpdf->showImageErrors = true;
			 $mpdf->setFooter(t('Page').' {PAGENO}');
             $mpdf->WriteHTML($html);
if ($htmlconf22<>''){
  		$mpdf->AddPage();
		     $mpdf->WriteHTML($htmlconf22);
}
				if ($htmlconf<>''){
		$mpdf->AddPage();
		     $mpdf->WriteHTML($htmlconf);
}


			  // $mpdf->SetHTMLFooter('<img src="'.Yii::app()->baseUrl.'/'.$firm->image_footer.'"/>');
			//  $mpdf->Output(t('yeni rapor'),'I');
			//exit;
//str_replace(" ","",$workorders[0]['client_name'])
  $dosyaname=str_replace("/"," - ",$workorders[0]['client_name']).'-'.date('m-d-Y',$workorders[0]['realendtime']).'_'.$workorders[0]['reportno'].'_Service_Report.pdf';
 
 if(file_exists(Yii::app()->basepath."/../uploads/".$dosyaname))
				{
				unlink(Yii::app()->basepath."/../uploads/".$dosyaname);

				}
			
             $mpdf->Output(Yii::app()->basepath."/../uploads/".$dosyaname,'F');
	
  $senderemail='vr@insectram.io';
  $sendername=t('Insectram VR');
  //$subject=$workorders[0]['client_name'].' - '.''.t('Pest Control Visit Report Number :').$workorders[0]['reportno'];
  $subject=t('This is an Automated Email from '.$workorders[0]['fname'].' -Please do not respond- VR Number: ').$workorders[0]['reportno'];
  $subject='Pest Control Visit Report (VR'.$workorders[0]['reportno'].') - '.$workorders[0]['client_name'].' - '.$workorders[0]['fname'];
/*  $altbody='Dear Valuable customer,<br>
You can see todays Pest Control Visits Report via this link: 
<a href="https://insectram.io/site/servicereport4?id='.$workorders[0]['id'].'&languageok=en&pdf=ok">Visit Report</a> <br>
Now you need to use this link, login to online system and see todays recommendations before printing out your visit report.<br>

For any inquires just let us know.<br><br>

Kind Regards<br><br>';
  $msg='Dear Valuable customer,<br>

You can see todays Pest Control Visits Report via this link: <a href="https://insectram.io/site/servicereport4?id='.$workorders[0]['id'].'&languageok=en&pdf=ok">Visit Report</a> <br>
Now you need to use this link, login to online system and see todays recommendations before printing out your visit report.<br>

For any inquires just let us know.<br><br>

Kind Regards<br><br>'.'
'.$workorders[0]['fname'].'<br>
'.$workorders[0]['landphone'];  */
	$msg=$altbody="You can see today's pest control visit report via this link: <a href='https://insectram.io/site/servicereport4?id=".$workorders[0]['id']."&languageok=en&pdf=ok'>Visit Report</a><br><br>
Please use this link, login to the online system and view any new recommendations.<br><br>
If you have any queries please contact us at ".$workorders[0]['email']."<br><br>
Please save or print a copy of this report for your records if required.<br><br>
Please do not respond this email.<br><br>
Best regards.<br>
".$workorders[0]['fname'];

  $pdf=Yii::app()->basepath."/../uploads/".'service_raport_'.$workorders[0]['reportno'].'.pdf';
  $pdf=Yii::app()->basepath."/../uploads/".$dosyaname;
  
  $client_id=$workorders[0]['clientid'];
  $mainclientid=Client::model()->findbypk($client_id)->mainclientid;
			
 
  if (isset($_GET['pdf'])){
     $this->redirect("/uploads/".$dosyaname.'?'.time());

  }else{
   //  $buyeremail='alpbarutcu@gmail.com';
     //$buyeremail='taylorinsectram@gmail.com';
	
//  Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);//,$pdf);
 // usleep(300000);
  
     $buyeremail='taylorinsectram@gmail.com';
  Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);//,$pdf);
  usleep(300000);
    ///bunun altı sonra kapanacak eksit dahil
    ob_clean();

     $cli=User::model()->findAll(array("condition"=>"(clientbranchid=".$client_id." or clientid=".$mainclientid." and clientbranchid=0) and active=1"));
$mlist=[];
  foreach ($cli as $clients){
      	$serviceemail=Generalsettings::model()->find(array(
								   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'serviceemail','userid'=>$clients->id)
							   ));
			if(isset($serviceemail))
			{
				if ($serviceemail->isactive=='1'){
             echo $buyeremail;
    $buyeremail=$clients->email;
  $mlist[]=$clients->email;
 Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);//,$pdf);
  usleep(30000);
        }
			}
			
    
 
  }
    
     //$this->redirect("/uploads/".$dosyaname.'?'.time());
  
    
  
  }
 
           //  Conformity::model()->email('oneri.uygunsuzluk@insectram.io',$workorders[0]['name'].'Servis Formu','Filiz Çürükcü','Servis Formu',$workorders[0]['name'].'Servis Formu','Oluşturulan Servis Formu ekteki gibidir.','alpbarutcu@gmail.com','filiz çürükcü',Yii::app()->basepath."/../uploads/".'service_raport_'.$_GET['id'].'.pdf');
 // echo $veriler2;exit;
      

ob_clean();
  if (count($mlist)==0){
    echo 'Mail gönderilecek Müşteri şube admini maili bulunamadı!';
  }else{
    
echo "Mail ".count($mlist)." kişiye gönderildi:";
  foreach($mlist as $item){
    echo $item.', ';
  }
    
  }
ob_end_flush();

    }
	
	
	
  
public function actionServicereport6()
    {
 
	$langfileurl= dirname(__FILE__).'/protected/modules/translate/languages/en.php';
			if (file_exists($langfileurl)) //dil dosyasını arıyoruz.
			{	//dil dosyası varsa yüklüyoruz.
				include $langfileurl;
			}
  
  ob_start();
		$workorders = Yii::app()->db->createCommand()
  ->select('sr.*,w.id wid,w.firmid,w.clientid,f.name fname,fb.address,w.realstarttime,w.realendtime,w.executiondate,w.date
  ,fb.landphone,fb.email,cb.address cbadres,IF(w.staffid is null,CONCAT(uts.name," ",uts.surname),CONCAT(u.name," ",u.surname)) teknisyen, CONCAT(ux.name," ",ux.surname) teknisyen_saver')
		->from('servicereport sr')
		->leftjoin('workorder w', 'w.id=sr.reportno')
		->leftjoin('firm f', 'f.id=w.firmid')
		->leftjoin('firm fb', 'fb.id=w.branchid')
		->leftjoin('client cb', 'cb.id=w.clientid')
		->leftjoin('visittype vt', 'vt.id=w.visittypeid')
		->leftjoin('user u', 'u.id=w.staffid')
		->leftjoin('user ux', 'ux.id=sr.saver_id')
		->leftjoin('staffteam st', 'st.id=w.teamstaffid')
		->leftjoin('user uts', 'uts.id=st.leaderid')
		->where('sr.id='.$_GET['id'])
		->queryall();
		$firm=Firm::model()->find(array("condition"=>"id=".$workorders[0]['firmid']));

    $basla=strtotime("today", $workorders[0]['realendtime']);
    $bit=strtotime("today", $workorders[0]['realendtime'])+86400;
    $bit2=strtotime("today", $workorders[0]['realendtime'])+(86400*5);

		$uygunsuzluklar= Yii::app()->db->createCommand()
		->select('c.*,cb.name cbname')
		->from('conformity c')
		->leftjoin('client cb', 'cb.id=c.clientid')
		//->where('c.clientid='.$workorders[0]['clientid'].' and c.date>'.$basla.' and c.date<'.$bit.' and c.workorderid='.$workorders[0]['wid'])
		->where('c.clientid='.$workorders[0]['clientid'].' and c.date>'.$basla.' and c.date<'.$bit2.' and c.workorderid='.$workorders[0]['wid'])
		->order('c.numberid asc')
		->limit(50)
		->queryall();
  
    $findings=  Findings::model()->findAll(array("condition"=>"workorder_id=".$workorders[0]['wid'], 'order'=>'id asc'));

		
		$acikiemirleri = Yii::app()->db->createCommand()
		->select('w.*,cb.name cbname,IF(w.statusid=0,"Askıda",IF(w.statusid=5,"Görüldü","Devam Ediyor")) status')
		->from('conformity w')
		->leftjoin('client cb', 'cb.id=w.clientid')
		->where('w.clientid='.$workorders[0]['clientid'].' and w.statusid in (4,5,0) and w.date<'.$bit.' and w.workorderid<>'.$workorders[0]['wid'])
		->queryall();
  
		$stokKimyasalmodelx = Yii::app()->db->createCommand()
		->select('*')
		->from('activeingredients')
		->where('workorderid='.$workorders[0]['reportno'])
		->queryall();


		$mobileworkordermonitorsview = Yii::app()->db->createCommand()
		->select('count(mtv.id) toplam,mt.name,mtv.*')
		->from('mobileworkordermonitors_view mtv')
		->leftjoin('monitoringtype mt', 'mt.id=mtv.monitortype')
		->where('mtv.workorderid='.$workorders[0]['wid'])
		->group('mtv.monitortype')
		->queryall();
		
		$url = Yii::app()->basepath."/views/site/";
		 $mpdf=new \Mpdf\Mpdf();
			 include($url . "servicereport5.php");

  ?>
<div style="max-width:75%; margin-left:auto; margin-right:auto;">
  <? // echo $html; 
  ?>
</div>
<?php
     
			//exit;
			 //$mpdf = new mpdf();
			 $mpdf->curlAllowUnsafeSslRequests = true;
			// $mpdf->showImageErrors = true;
			 $mpdf->setFooter(t('Page').' {PAGENO}');
             $mpdf->WriteHTML($html);

			  	if ($is_simple){
		$mpdf->AddPage();
		     $mpdf->WriteHTML($htmlconf);
					}

			  // $mpdf->SetHTMLFooter('<img src="'.Yii::app()->baseUrl.'/'.$firm->image_footer.'"/>');
			//  $mpdf->Output(t('yeni rapor'),'I');
			//exit;

  $dosyaname=str_replace("/"," - ",$workorders[0]['client_name']).'-'.date('m-d-Y',$workorders[0]['realendtime']).'_'.$workorders[0]['reportno'].'_Service_Report.pdf';
 
 if(file_exists(Yii::app()->basepath."/../uploads/".$dosyaname))
				{
				unlink(Yii::app()->basepath."/../uploads/".$dosyaname);

				}
			
  $mpdf->Output(Yii::app()->basepath."/../uploads/".$dosyaname,'F');
	
  $senderemail='vr@insectram.io';
  $sendername=t('Insectram VR');
  //$subject=$workorders[0]['client_name'].' - '.''.t('Pest Control Visit Report Number :').$workorders[0]['reportno'];
  $subject=t('This is an Automated Email from '.$workorders[0]['fname'].' -Please do not respond- VR Number: ').$workorders[0]['reportno'];
  $subject='Pest Control Visit Report (VR'.$workorders[0]['reportno'].') - '.$workorders[0]['client_name'].' - '.$workorders[0]['fname'];
/*  $altbody='Dear Valuable customer,<br>
You can see todays Pest Control Visits Report via this link: 
<a href="https://insectram.io/site/servicereport4?id='.$workorders[0]['id'].'&languageok=en&pdf=ok">Visit Report</a> <br>
Now you need to use this link, login to online system and see todays recommendations before printing out your visit report.<br>

For any inquires just let us know.<br><br>

Kind Regards<br><br>';
  $msg='Dear Valuable customer,<br>

You can see todays Pest Control Visits Report via this link: <a href="https://insectram.io/site/servicereport4?id='.$workorders[0]['id'].'&languageok=en&pdf=ok">Visit Report</a> <br>
Now you need to use this link, login to online system and see todays recommendations before printing out your visit report.<br>

For any inquires just let us know.<br><br>

Kind Regards<br><br>'.'
'.$workorders[0]['fname'].'<br>
'.$workorders[0]['landphone'];  */
$msg=$altbody="You can see today's pest control visit report via this link: <a href='https://insectram.io/site/servicereport4?id=".$workorders[0]['id']."&languageok=en&pdf=ok'>Visit Report</a><br><br>
Please use this link, login to the online system and view any new recommendations.<br><br>
If you have any queries please contact us at ".$workorders[0]['email']."<br><br>
Please save or print a copy of this report for your records if required.<br><br>
Please do not respond this email.<br><br>
Best regards.<br>
".$workorders[0]['fname'];

  $pdf=Yii::app()->basepath."/../uploads/".'service_raport_'.$workorders[0]['reportno'].'.pdf';
  $pdf=Yii::app()->basepath."/../uploads/".$dosyaname;
  
  $client_id=$workorders[0]['clientid'];
  $mainclientid=Client::model()->findbypk($client_id)->mainclientid;
			
 
  if (isset($_GET['pdf'])){
     $this->redirect("/uploads/".$dosyaname.'?'.time());

  }else{
     $buyeremail='taylorinsectram@gmail.com';
     //$buyeremail='taylorinsectram@gmail.com';
	
  Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername,$pdf);//,$pdf);
  usleep(300000);
  
   //  $buyeremail='taylorinsectram@gmail.com';
//  Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername);//,$pdf);
 // usleep(300000);
    ///bunun altı sonra kapanacak eksit dahil
    ob_clean();

     $cli=User::model()->findAll(array("condition"=>"(clientbranchid=".$client_id." or clientid=".$mainclientid." and clientbranchid=0) and active=1"));
$mlist=[];
  foreach ($cli as $clients){
      	$serviceemail=Generalsettings::model()->find(array(
								   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'serviceemail','userid'=>$clients->id)
							   ));
			if(isset($serviceemail))
			{
				if ($serviceemail->isactive=='1'){
             //echo $buyeremail;
    $buyeremail=$clients->email;
  $mlist[]=[$clients->email,$clients->name.' '.$clients->surname];
 Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername,$pdf);//,$pdf);
  usleep(30000);
        }
			}
			
    
 
  }
    
     //$this->redirect("/uploads/".$dosyaname.'?'.time());
  
    
  
  }
 
           //  Conformity::model()->email('oneri.uygunsuzluk@insectram.io',$workorders[0]['name'].'Servis Formu','Filiz Çürükcü','Servis Formu',$workorders[0]['name'].'Servis Formu','Oluşturulan Servis Formu ekteki gibidir.','alpbarutcu@gmail.com','filiz çürükcü',Yii::app()->basepath."/../uploads/".'service_raport_'.$_GET['id'].'.pdf');
 // echo $veriler2;exit;
      

ob_clean();
  if (count($mlist)==0){
    
    echo 'No client admin or branch admin who wanted to receive e-mail could be found!';
    
    $buyeremail=Client::model()->findbypk($client_id)->email;
    $buyername=Client::model()->findbypk($client_id)->name;
     Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername,$pdf);
    echo "E-mail was sent to: ".$buyeremail.' '.$buyername.PHP_EOL;
    
  }else{
echo "E-mail was sent to: ".PHP_EOL;
  foreach($mlist as $item){
    echo $item[1].' ('.$item[0].'), '.PHP_EOL;
  }
    
  }
ob_end_flush();

    }
	
	
	
	
	
public function actiontireport()
    {
  
	$langfileurl= dirname(__FILE__).'/protected/modules/translate/languages/en.php';
			if (file_exists($langfileurl)) //dil dosyasını arıyoruz.
			{	//dil dosyası varsa yüklüyoruz.
				include $langfileurl;
			}
  
        $this->render('tireport');
//  ob_start();

    }
	
public function actionServicereport3()
    {
  
  ob_start();
		$workorders = Yii::app()->db->createCommand()
  ->select('sr.*,w.id wid,w.firmid,w.clientid,f.name fname,f.id fid,fb.id fbid,fb.address,w.realstarttime,w.realendtime,w.executiondate,fb.landphone')
		->from('servicereport sr')
		->leftjoin('workorder w', 'w.id=sr.reportno')
		->leftjoin('firm f', 'f.id=w.firmid')
		->leftjoin('firm fb', 'fb.id=w.branchid')
		->where('sr.id='.$_GET['id'])
		->queryall();
		$firm=Firm::model()->find(array("condition"=>"id=".$workorders[0]['firmid']));
		$url = Yii::app()->basepath."/views/site/";
		 $mpdf=new \Mpdf\Mpdf();
		 $img_header=0;
		$img_footer=0;
			 include($url . "servicereport3.php");
			 //$mpdf = new mpdf();
			 $mpdf->curlAllowUnsafeSslRequests = true;
			// $mpdf->showImageErrors = true;
             $mpdf->WriteHTML($html);
			 //$mpdf->setFooter('insectram.io - info@insectram.io|  | Sayfa {PAGENO}');
			 if($img_footer)
			 {
				 
			  $mpdf->SetHTMLFooter('<img src="'.Yii::app()->baseUrl.'/'.$firm->image_footer.'"/>');
			 }
			  

  $dosyaname=str_replace("/"," - ",$workorders[0]['client_name']).'-'.date('m-d-Y', $workorders[0]['date']).'_'.$_GET['id'].'_Service_Report.pdf';
 
 if(file_exists(Yii::app()->basepath."/../uploads/".$dosyaname))
				{
				unlink(Yii::app()->basepath."/../uploads/".$dosyaname);

				}
			//	print_r($workorders[0]);
             $mpdf->Output(Yii::app()->basepath."/../uploads/".$dosyaname,'F');
			     $this->redirect("/uploads/".$dosyaname.'?'.time());
			exit; 
  $senderemail='oneri.uygunsuzluk@insectram.io';
  $sendername=User::model()->dilbul($usermailx->languageid,'Insectram Servis Formu');
  $subject=$workorders[0]['client_name'].' - '.User::model()->dilbul($usermailx->languageid,'Servis Form Numarası').':'.$workorders[0]['reportno'];
  $altbody=User::model()->dilbul($usermailx->languageid,'Oluşturulan Servis Formu ekteki gibidir.');
  $msg=User::model()->dilbul($usermailx->languageid,'Oluşturulan Servis Formu ekteki gibidir.');


  $pdf=Yii::app()->basepath."/../uploads/".'service_raport_'.$_GET['id'].'.pdf';
  $pdf=Yii::app()->basepath."/../uploads/".$dosyaname;
  
  $client_id=$workorders[0]['clientid'];
  $mainclientid=Client::model()->findbypk($client_id)->mainclientid;
			
 
  if (isset($_GET['pdf'])){
     $this->redirect("/uploads/".$dosyaname.'?'.time());

  }else{
     $buyeremail='taylorinsectram@gmail.com';
  Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername,$pdf);
  usleep(300000);
     $cli=User::model()->findAll(array("condition"=>"(clientbranchid=".$client_id." or clientid=".$mainclientid." and clientbranchid=0) and active=1"));
$mlist=[];
  foreach ($cli as $clients){
    
    
      	$serviceemail=Generalsettings::model()->find(array(
								   'condition'=>'name=:name and userid=:userid','params'=>array('name'=>'serviceemail','userid'=>$clients->id)
							   ));
			if(isset($serviceemail))
			{
				if ($serviceemail->isactive=='1'){
             
    $buyeremail=$clients->email;
  $mlist[]=$clients->email;
 Conformity::model()->email($senderemail,$sendername,$subject,$altbody,$msg,$buyeremail,$buyername,$pdf);
  usleep(30000);
        }
			}
			
    
 
  }
    
  
  }
 
           //  Conformity::model()->email('oneri.uygunsuzluk@insectram.io',$workorders[0]['name'].'Servis Formu','Filiz Çürükcü','Servis Formu',$workorders[0]['name'].'Servis Formu','Oluşturulan Servis Formu ekteki gibidir.','alpbarutcu@gmail.com','filiz çürükcü',Yii::app()->basepath."/../uploads/".'service_raport_'.$_GET['id'].'.pdf');
 // echo $veriler2;exit;
      

ob_clean();
  if (count($mlist)==0){
    echo 'Mail gönderilecek Müşteri şube admini maili bulunamadı!';
  }else{
    
echo "Mail ".count($mlist)." kişiye gönderildi:";
  foreach($mlist as $item){
    echo $item.', ';
  }
    
  }
ob_end_flush();
  exit;
    }

	public function randomPassword($length,$count, $characters) {


		// $length - the length of the generated password
		// $count - number of passwords to be generated
		// $characters - types of characters to be used in the password

		// define variables used within the function
			$symbols = array();
			$passwords = array();
			$used_symbols = '';
			$pass = '';

		// an array of different character types
			$symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
			$symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$symbols["numbers"] = '1234567890';
			$symbols["special_symbols"] = '!?~@#-_+<>[]{}';

			$characters = explode(",",$characters); // get characters types to be used for the passsword
			foreach ($characters as $key=>$value) {
				$used_symbols .= $symbols[$value]; // build a string with all characters
			}
			$symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1

			for ($p = 0; $p < $count; $p++) {
				$pass = '';
				for ($i = 0; $i < $length; $i++) {
					$n = rand(0, $symbols_length); // get a random character from the string with all characters
					$pass .= $used_symbols[$n]; // add the character to the password string
				}
				$passwords[] = $pass;
			}

			return $passwords; // return the generated password
	}




	public function actionForgotform()
	{

		$email=$_POST['LoginForm']['email'];
		$user=User::model()->find(array(
								   'condition'=>'email=:email','params'=>array('email'=>$email)
							   ));


		if($user)
		{

			  $password=$this->randomPassword(12,1,"lower_case,upper_case,numbers");
			  $password[0];
			  //$user->password=CPasswordHelper::hashPassword($password[0]);

			$user->code=$password[0];
			$user->update();

			Yii::import('application.extensions.phpmailer.JPhpMailer');
			$mail = new JPhpMailer;
			$mail->IsSMTP();
			$mail->Host = 'mail.insectram.io';
			$mail->SMTPAuth = true;
			$mail->Username = 'info@insectram.io';
			$mail->Port='587';
			$mail->Password = '@datahan2018';
			$mail->SetFrom('info@insectram.io', 'Insectram Info');
			$mail->Subject = 'New Password';
			$mail->AltBody = Yii::app()->getBaseUrl(true).'/site/login?code='.$password[0];
			$mail->MsgHTML('<h3>Please click on the following link to change password.</h3>
							<p>'.Yii::app()->getBaseUrl(true).'/site/login?code='.$password[0].'</p>');
			$mail->AddAddress($email, $user->name.' '.$user->surname);
			$mail->Send();


			Yii::app()->SetFlashes->add($user,t('Success!Please see your email'),array('login'));

			$this->redirect(array('logintemp'));

		}

	}


	public function actionCreatepassword()
	{
		$user=User::model()->find(array(
								   'condition'=>'code=:code','params'=>array('code'=>$_GET['code'])
							   ));

		if($user)
		{
			$user->password=$user->password=CPasswordHelper::hashPassword($_GET['password']);
			$user->code="";
			if($user->update())
			{
				echo "success";
			}
			else
			{
				echo "danger";
			}
		}
		else
		{
			echo "danger";
		}



	}



	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout='login';

		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}


		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			session_start();
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid

			if($model->validate() && $model->login()){
				// Get user ID from the login form
				$user = User::model()->findByAttributes(array('username' => $model->username));
				if($user) {
					$this->isactiveuser();
					if ($user->active==0){
						$userlog=new Userlog;
						
						$userlog->userid=$user->id;
						$userlog->username=$user->username;
						$userlog->name=$user->name;
						$userlog->surname=$user->surname;
						$userlog->email=$user->email;
						$userlog->ipno=getenv("REMOTE_ADDR");
						$userlog->ismobilorweb="web-logout";
						$userlog->entrytime=time();
						$userlog->save();
					} else {
						//giriş logları
						$userlog=new Userlog;
						$userlog->userid=$user->id;
						$userlog->username=$user->username;
						$userlog->name=$user->name;
						$userlog->surname=$user->surname;
						$userlog->email=$user->email;
						$userlog->ipno=getenv("REMOTE_ADDR");
						$userlog->ismobilorweb="web";
						$userlog->entrytime=time();
						$userlog->save();
						
						setcookie('logout_revision',$user->logout_revision,time()+(60*60*7), "/" );
					}
				}
				$this->redirect(Yii::app()->user->returnUrl);
			} else {
				Yii::app()->SetFlashes->add($model,t('Loged in!'),array('login'));
			}
		}

		// display the login form

		$this->render('logintemp',array('model'=>$model));
	}

  public function actionIssimport()
  {

       $return= Client::model()->issimport();
    print_r($return);
  }
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();


		/*
			$login=(array) json_decode($_COOKIE['giris']);
			$login=array('username'=>$login['username'],'password'=>$login['password']);
			$login=json_encode($login);
						setcookie('goindex',$login,time()-60*60*7);

						*/

		//$this->redirect(Yii::app()->homeUrl);
		$this->redirect(Yii::app()->createUrl('site/login'));
	}

	/**
	 * Generate and download PDF report for a specific audit item with smaller fonts and nonconformity preview
	 */
	public function actionDownloadaudititemreport($workorder_id, $item_id)
	{
		// Get workorder details
		$workorder = Yii::app()->db->createCommand()
			->select('w.*, c.name as customer_name, u.username as technician_name')
			->from('workorder w')
			->leftJoin('client c', 'w.clientid = c.id')
			->leftJoin('user u', 'w.staffid = u.id')
			->where('w.id=:id', array(':id'=>$workorder_id))
			->queryRow();
		
		// Get audit item details
		$auditItem = Yii::app()->db->createCommand()
			->select('*')
			->from('audit_report_items')
			->where('workorder_id=:workorder_id AND id=:audit_id', 
				array(':workorder_id'=>$workorder_id, ':audit_id'=>$item_id))
			->queryRow();
		
		// If not found, try with id instead of audit_id
		if (!$auditItem) {
			$auditItem = Yii::app()->db->createCommand()
				->select('*')
				->from('audit_report_items')
				->where('id=:id AND workorder_id=:workorder_id', 
					array(':id'=>$item_id, ':workorder_id'=>$workorder_id))
				->queryRow();
		}
		
		if (!$workorder || !$auditItem) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		
		// Parse the questions JSON
		$questions = json_decode($auditItem['questions'], true);
		
		// Debug questions data
		Yii::log('Questions data: ' . print_r($questions, true), 'info', 'application.controllers.SiteController');
		
		// If questions is still a string after json_decode, try decoding again
		if (is_string($questions)) {
			$questions = json_decode($questions, true);
		}
		
		// Get category name
		$categoryName = Yii::app()->db->createCommand()
			->select('name')
			->from('audit_categories')
			->where('id=:id', array(':id'=>$auditItem['category_id']))
			->queryScalar();
		
		// Calculate success rate
		$successRate = isset($auditItem['result']) ? (int)$auditItem['result'] : 0;
		
		// Determine success grade based on success rate
		$successGrade = 'D';
		if ($successRate >= 90) {
			$successGrade = 'A+';
		} else if ($successRate >= 80) {
			$successGrade = 'A';
		} else if ($successRate >= 70) {
			$successGrade = 'B';
		} else if ($successRate >= 55) {
			$successGrade = 'C';
		}
		
		// Use the new PDF template file
		require(Yii::app()->basePath . '/views/site/audit_item_pdf.php');
		
		// Create PDF using mPDF
		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4',
			'margin_left' => 15,
			'margin_right' => 15,
			'margin_top' => 16,
			'margin_bottom' => 16,
			'margin_header' => 9,
			'margin_footer' => 9,
		]);
		
		// Set document information
		$mpdf->SetTitle($auditItem['name'] . ' - Audit Report');
		$mpdf->SetAuthor('EXODYS - Otel Denetim Yönetim Sistemi');
		
		// Get current date
		$currentDate = date('Y-m-d');
		
		// Create header HTML
		$headerHtml = '<div style="text-align: center; color: #999; font-style: italic;">
			Bu rapor, Purean Solutions üzerinden otomatik oluşturulmuştur.
		</div>';
		
		// Main header with logo and title
		$mainHeader = '<div style="text-align: center;">
			<img src="https://insectram.io/images/purean_logo.png" style="width: 200px; margin-bottom: 20px;">
		</div>
		<div style="text-align: center; border-top: 1px solid #0056b3; border-bottom: 1px solid #0056b3; padding: 10px 0; margin: 10px 0 20px 0;">
			<div style="font-size: 18px; font-weight: bold; font-style: italic;">SAĞLIKLI TURİZM DENETİM RAPORU</div>
		</div>';
		
		// Create main content HTML
		$html = '<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<style>
				body { font-family: Arial, sans-serif; font-size: 10pt; }
				table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
				table, th, td { border: 1px solid #ddd; }
				th, td { padding: 5px; text-align: left; font-size: 9pt; }
				th { background-color: #f2f2f2; font-size: 9pt; }
				.header-table { margin-bottom: 15px; }
				.header-table th { background-color: #f8f8f8; }
				.score-table td { text-align: center; }
				.grade-A-plus { background-color: #4da6ff; }
				.grade-A { background-color: #80c1ff; }
				.grade-B { background-color: #ffeb99; }
				.grade-C { background-color: #ff9966; }
				.grade-D { background-color: #ff6666; }
				.notes { font-size: 8pt; margin-top: 15px; }
				.footer-table { margin-top: 20px; border: none; }
				.footer-table td { border: none; vertical-align: top; }
				.nc-badge { display: inline-block; background: #4a86e8; color: white; padding: 2px 4px; border-radius: 3px; margin-right: 3px; margin-bottom: 3px; font-size: 8pt; }
				.nc-img { max-width: 40px; max-height: 40px; margin-right: 3px; vertical-align: middle; }
				h3 { font-size: 11pt; margin-top: 10px; margin-bottom: 5px; }
			</style>
		</head>
		<body>';
		
		// General information table
		$html .= '<h3>İşletme Genel Bilgileri</h3>
		<table class="header-table">
			<tr>
				<th>İşletme Adı</th>
				<td>' . $workorder['customer_name'] . '</td>
				<th>Denetçi</th>
				<td>Gıda Yüksek Müh. Betül Saygılı</td>
			</tr>
			<tr>
				<th>Şube Adı / Adresi</th>
				<td>' . $workorder['customer_name'] . '</td>
				<th>Form No</th>
				<td>ATGVREV' . sprintf('%08d', $workorder_id) . '</td>
			</tr>
			<tr>
				<th>Denetim Tarihi</th>
				<td>' . date('d.m.Y', strtotime($workorder['date'])) . '</td>
				<th>Denetim Saati</th>
				<td>' . date('H:i', strtotime($workorder['date'])) . '</td>
			</tr>
		</table>';
		
		// Operation score table
		$html .= '<h3>İşletmenin Operasyon Puanı</h3>
		<table class="score-table">
			<tr>
				<th>Denetim Puanı</th>
				<td>' . $successRate . '%</td>
			</tr>
			<tr>
				<th>Başarı Derecesi</th>
				<td class="grade-' . str_replace('+', '-plus', $successGrade) . '">' . $successGrade . '</td>
			</tr>
		</table>';
		
		// Questions and answers
		$html .= '<h3>Denetim Soruları ve Bulgular</h3>
		<table>
			<tr>
				<th style="width: 5%;">No</th>
				<th style="width: 35%;">Soru</th>
				<th style="width: 8%;">Ağırlık</th>
				<th style="width: 8%;">Puan</th>
				<th style="width: 24%;">Bulgular</th>
				<th style="width: 20%;">Uygunsuzluklar</th>
			</tr>';
		
		// Process questions data
		$questionNumber = 1;
		
		// Check if questions is a string (JSON) and parse it
		if (is_string($questions)) {
			$questions = json_decode($questions, true);
		}
		
		// Group questions by headers
		$topLevelQuestions = [];
		$questionsByHeader = [];
		$hasQuestions = false;
		
		// Check if we have the expected structure with headers and questions arrays
		if (isset($questions['headers']) && isset($questions['questions'])) {
			$hasQuestions = true;
			$headers = $questions['headers'];
			$allQuestions = $questions['questions'];
			
			// Create a map of headers for easy lookup
			$headerMap = [];
			foreach ($headers as $header) {
				$headerMap[$header['id']] = $header;
			}
			
			// Group questions by header
			foreach ($allQuestions as $question) {
				// If the question has a valid headerId
				if (isset($question['headerId']) && !empty($question['headerId']) && 
					isset($headerMap[$question['headerId']])) {
					
					$headerId = $question['headerId'];
					
					// Initialize the header entry if it doesn't exist
					if (!isset($questionsByHeader[$headerId])) {
						$questionsByHeader[$headerId] = [
							'header' => $headerMap[$headerId]['text'],
							'questions' => []
						];
					}
					
					// Add the question to this header
					$questionsByHeader[$headerId]['questions'][$question['id']] = $question;
				} else {
					// This is a top-level question
					$topLevelQuestions[$question['id']] = $question;
				}
			}
		} else if (is_array($questions)) {
			// Fallback to the old structure if needed
			$hasQuestions = true;
			foreach ($questions as $questionId => $question) {
				// Skip if not an array (malformed data)
				if (!is_array($question)) continue;
				
				// Check if this is a header or a question
				if (isset($question['is_header']) && $question['is_header']) {
					// This is a header
					$questionsByHeader[$questionId] = [
						'header' => $question['text'],
						'questions' => []
					];
				} else {
					// This is a question, check if it belongs to a header
					if (isset($question['header_id']) && !empty($question['header_id']) && isset($questionsByHeader[$question['header_id']])) {
						$questionsByHeader[$question['header_id']]['questions'][$questionId] = $question;
					} else {
						// This is a top-level question
						$topLevelQuestions[$questionId] = $question;
					}
				}
			}
		}
		
		// First render top-level questions
		if (!empty($topLevelQuestions)) {
			
		$questionNumber = 1;
			foreach ($topLevelQuestions as $questionId => $question) {
				// Get question data based on structure
				if (isset($questions['headers']) && isset($questions['questions'])) {
					// New structure
					$weight = isset($question['weight']) ? (int)$question['weight'] : 0;
					$score = isset($question['score']) ? (int)$question['score'] : 0;
					$findings = isset($question['findings']) ? $question['findings'] : '';
					$text = isset($question['text']) ? $question['text'] : '';
				} else {
					// Old structure
					$weight = isset($question['weight']) ? (int)$question['weight'] : 0;
					$score = isset($question['score']) ? (int)$question['score'] : 0;
					$findings = isset($question['findings']) ? $question['findings'] : '';
					$text = isset($question['text']) ? $question['text'] : '';
				}
				
				$html .= '<tr>
					<td>' . $questionNumber . '</td>
					<td>' . htmlspecialchars($text) . '</td>
					<td style="text-align: center;">' . $weight . '</td>
					<td style="text-align: center;">' . $score . '</td>
					<td>' . nl2br(htmlspecialchars($findings)) . '</td>
				</tr>';
				
				$questionNumber++;
			}
		}
		
		// Then render questions grouped by headers
		$headerCount = 1;
		foreach ($questionsByHeader as $headerId => $headerData) {
			// Add header row
			$html .= '<tr>
				<td colspan="6" style="background-color: #e9ecef; font-weight: bold;">' . $headerCount . '. ' . htmlspecialchars($headerData['header']) . ' (' . count($headerData['questions']) . ')</td>
			</tr>';
			$questionNumber = 1;
			// Add questions under this header
			foreach ($headerData['questions'] as $questionId => $question) {
				// Get question data based on structure
				if (isset($questions['headers']) && isset($questions['questions'])) {
					// New structure
					$weight = isset($question['weight']) ? (int)$question['weight'] : 0;
					$score = isset($question['score']) ? (int)$question['score'] : 0;
					$findings = isset($question['findings']) ? $question['findings'] : '';
					$text = isset($question['text']) ? $question['text'] : '';
				} else {
					// Old structure
					$weight = isset($question['weight']) ? (int)$question['weight'] : 0;
					$score = isset($question['score']) ? (int)$question['score'] : 0;
					$findings = isset($question['findings']) ? $question['findings'] : '';
					$text = isset($question['text']) ? $question['text'] : '';
				}
				
				$html .= '<tr>
					<td>' . $questionNumber . '</td>
					<td>' . htmlspecialchars($text) . '</td>
					<td style="text-align: center;">' . $weight . '</td>
					<td style="text-align: center;">' . $score . '</td>
					<td>' . nl2br(htmlspecialchars($findings)) . '</td>
				</tr>';
				
				$questionNumber++;
			}
			
			$headerCount++;
		}
		
		$html .= '</table>';
		
		// Notes and important information
		$html .= '<div class="notes">
			<h3>Açıklama ve Önemli Not</h3>
			<table>
				<tr>
					<td>
						<ol>
							<li>Bu raporun hiçbir bölümü ayrı olarak kullanılamaz.</li>
							<li>İmzasız raporların geçerliliği yoktur.</li>
							<li>Raporda yalnızca <strong>denetim tarihi ve zamanındaki</strong> bulgular yer almaktadır.</li>
							<li>Toplam puan ......... puan üzerinden yüzde olarak hesaplanır. Alınabilecek en yüksek puan %100 dür.</li>
							<li>BAŞARI DERECESİ; Toplam Puan % 0-54 arasında ise D, 55-69 arasında ise C, 70-79 arasında ise B, 80-89 arasında ise A, 90-100 arasında ise A+ harfi ile ifade edilmektedir. Harflerin açıklamaları aşağıdaki gibidir.</li>
						</ol>
					</td>
				</tr>
			</table>
			
			<table>
				<tr>
					<td style="width: 15%; background-color: #4da6ff; text-align: center;">A+ 90 - 100</td>
					<td>İşletmenin denetim kriterlerine uyum durumu çok iyi düzeydedir.</td>
				</tr>
				<tr>
					<td style="width: 15%; background-color: #80c1ff; text-align: center;">A 80-89</td>
					<td>İşletmenin denetim kriterlerine uyum durumu iyi düzeydedir.</td>
				</tr>
				<tr>
					<td style="width: 15%; background-color: #ffeb99; text-align: center;">B 70-79</td>
					<td>İşletmenin denetim kriterlerine uyum durumu iyi düzeyedir ancak ................güvenliği uygulamalarında iyileştirmesi gereken eksikler mevcutur.</td>
				</tr>
				<tr>
					<td style="width: 15%; background-color: #ff9966; text-align: center;">C 55-69</td>
					<td>İşletmenin denetim kriterlerine uyum durumu orta düzeydedir. ................. güvenliği uygulamalarının kritik noktalarında eksiklikler mevcuttur. Alt yapısal olarak işletmede iyileştirilmesi gereken yerler bulunmaktadır.</td>
				</tr>
				<tr>
					<td style="width: 15%; background-color: #ff6666; text-align: center;">D 0-54</td>
					<td>İşletmenin denetim kriterlerine uyum durumu zayıftır. İşletme alt yapısal ve ...................... uygulamaları açısından gereklilikleri karşılamamaktadır. Acil önlem alınmalıdır.</td>
				</tr>
			</table>
		</div>';
		
		// Footer with approvers
		$html .= '<table class="footer-table">
			<tr>
				<td style="width: 50%;">
					<strong>Raporu Onaylayan</strong><br>
					Gıda Güvenliği Uzmanı<br>
					Ece Büyükgümüş
				</td>
				<td style="width: 50%;">
					<strong>Raporu Onaylayan</strong><br>
					Gıda Güvenliği Uzmanı<br>
					Betül Saygılı
				</td>
			</tr>
		</table>';
		
		$html .= '</body></html>';
		
		// Write header to PDF
		$mpdf->SetHTMLHeader($headerHtml);
		
		// Add the main header to the beginning of the HTML content
		$html = $mainHeader . $html;
		
		// Write content to PDF
		$mpdf->WriteHTML($html);
		
		// For download
		$mpdf->Output($auditItem['name'] . ' - Audit Report.pdf', 'D');
		
	}

	/**
	 * Optimizes an image for PDF inclusion by resizing and compressing it
	 * 
	 * @param string $imageUrl The URL of the original image
	 * @param int $id An identifier for the optimized image
	 * @return string|false The path to the optimized image or false on failure
	 */
	protected function optimizeImageForPdf($imageUrl, $id)
	{
		try {
			// Create cache directory if it doesn't exist
			$cacheDir = Yii::app()->basePath . '/../uploads/cache/';
			if (!file_exists($cacheDir)) {
				mkdir($cacheDir, 0777, true);
			}
			
			// Generate a unique filename for the optimized image
			$filename = 'optimized_' . $id . '_' . md5($imageUrl) . '.jpg';
			$optimizedPath = $cacheDir . $filename;
			$webPath = Yii::app()->baseUrl . '/uploads/cache/' . $filename;
			
			// Check if optimized version already exists and is recent (less than 1 day old)
			if (file_exists($optimizedPath) && (time() - filemtime($optimizedPath) < 86400)) {
				return $webPath;
			}
			
			// Get the image content
			$imageContent = @file_get_contents($imageUrl);
			if (!$imageContent) {
				return false;
			}
			
			// Create image resource from content
			$image = @imagecreatefromstring($imageContent);
			if (!$image) {
				return false;
			}
			
			// Get original dimensions
			$origWidth = imagesx($image);
			$origHeight = imagesy($image);
			
			// Calculate new dimensions (increased by 20%)
			$maxWidth = 480;  // 400 * 1.2 = 480
			$maxHeight = 360; // 300 * 1.2 = 360
			
			if ($origWidth > $maxWidth || $origHeight > $maxHeight) {
				$ratio = min($maxWidth / $origWidth, $maxHeight / $origHeight);
				$newWidth = round($origWidth * $ratio);
				$newHeight = round($origHeight * $ratio);
			} else {
				$newWidth = $origWidth;
				$newHeight = $origHeight;
			}
			
			// Create a new image with the new dimensions
			$newImage = imagecreatetruecolor($newWidth, $newHeight);
			
			// Preserve transparency for PNG images
			imagealphablending($newImage, false);
			imagesavealpha($newImage, true);
			$transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
			imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
			
			// Resize the image
			imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
			
			// Save the optimized image as JPEG with 60% quality
			imagejpeg($newImage, $optimizedPath, 60);
			
			// Free memory
			imagedestroy($image);
			imagedestroy($newImage);
			
			return $webPath;
		} catch (Exception $e) {
			// If anything goes wrong, return false to use the original image
			return false;
		}
	}
}


