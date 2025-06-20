<?php
/* @var $this SiteController */
/* @var $model AuditCategory */
/* @var $categories array */
/* @var $categoryDropdown array */

$this->pageTitle=Yii::app()->name . ' - '.t('Inspection Categories');
?>

<style>
.panel {
    background-color: white;
    margin-bottom: 20px;
}
.panel-body {
    background-color: white;
    padding: 20px;
}
.panel-heading {
    background-color: white !important;
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
}
.panel-title {
    font-weight: bold;
    color: #333;
}
</style>

<div class="row">
    <div class="col-md-12">
        <h1> <?=t('Inspection Categories Management')?></h1>
        
        <?php if(Yii::app()->user->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
        <?php endif; ?>
        
        <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"> <?=t('Add/Edit Category')?></h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="">
                            <?php if($isEdit): ?>
                                <input type="hidden" name="edit_id" value="<?php echo $editId; ?>">
                            <?php endif; ?>
                            
                            <div class="form-group">
                                <label for="category_name"> <?=t('Category Name')?></label>
                                <input type="text" class="form-control" id="category_name" name="name" value="<?php echo CHtml::encode($model['name']); ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="category_description"> <?=t('Description')?></label>
                                <textarea class="form-control" id="category_description" name="description" rows="3"><?php echo CHtml::encode($model['description']); ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="category_parent_id"> <?=t('Parent Category')?></label>
                                <select class="form-control" id="category_parent_id" name="parent_id">
                                    <?php 
                                    // First show the No Parent option
                                    if(isset($categoryDropdown['']) && !is_array($categoryDropdown[''])): ?>
                                        <option value="" <?php echo $model['parent_id'] == '' ? 'selected' : ''; ?>>
                                            <?php echo CHtml::encode($categoryDropdown['']); ?>
                                        </option>
                                    <?php endif; ?>
                                    
                                    <?php 
                                    // Then show only categories with NULL parent_id
                                    foreach($categoryDropdown as $id => $category): 
                                        // Skip the 'No Parent' option as we've already shown it
                                        if($id === '') continue;
                                        
                                        // Get the category data from the database to check parent_id
                                        if($id !== '') {
                                            $categoryData = Yii::app()->db->createCommand()
                                                ->select('parent_id')
                                                ->from('audit_categories')
                                                ->where('id=:id', array(':id'=>$id))
                                                ->queryRow();
                                                
                                            // Only show categories with NULL parent_id
                                            if($categoryData && $categoryData['parent_id'] !== null) {
                                                continue;
                                            }
                                        }
                                    ?>
                                        <?php if(is_array($category)): ?>
                                            <option value="<?php echo $id; ?>" <?php echo $model['parent_id'] == $id ? 'selected' : ''; ?>>
                                                <?php echo CHtml::encode($category['name']); ?>
                                            </option>
                                        <?php else: ?>
                                            <option value="<?php echo $id; ?>" <?php echo $model['parent_id'] == $id ? 'selected' : ''; ?>>
                                                <?php echo CHtml::encode($category); ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <?php echo $isEdit ? 'Update Category' : 'Create Category'; ?>
                            </button>
                            
                            <?php if($isEdit): ?>
                                <a href="<?php echo $this->createUrl('site/auditcategories'); ?>" class="btn btn-default"> <?=t('Cancel')?></a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-7">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"> <?=t('Category Hierarchy')?></h3>
                    </div>
                    <div class="panel-body">
                        <?php if(empty($categories)): ?>
                            <div class="alert alert-info"> <?=t('No categories found. Create your first category using the form.')?></div>
                        <?php else: ?>
                            <?php $this->renderPartial('_categoryTree', array('categories' => $categories)); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.category-tree {
    list-style-type: none;
    padding-left: 20px;
}

.category-tree li {
    margin: 5px 0;
}

.category-item {
    padding: 5px 10px;
    border-left: 3px solid #337ab7;
    background-color: #f8f9fa;
    margin-bottom: 5px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.category-name {
    font-weight: bold;
}

.category-description {
    font-style: italic;
    color: #666;
    margin-top: 3px;
}

.category-meta {
    font-size: 0.85em;
    color: #777;
    margin-top: 5px;
}

.category-meta span {
    display: inline-block;
    margin-right: 10px;
}

.category-meta .creator {
    color: #28a745;
}

.category-meta .firm {
    color: #007bff;
}

.category-meta .date {
    color: #6c757d;
}

.category-actions a {
    margin-left: 5px;
}
</style>