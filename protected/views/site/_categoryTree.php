<?php
/* @var $categories array */
?>

<ul class="category-tree">
    <?php foreach($categories as $category): ?>
        <li>
            <div class="category-item">
                <div>
                    <div class="category-name"><?php echo CHtml::encode($category['name']); ?></div>
                    <?php if(!empty($category['description'])): ?>
                        <div class="category-description"><?php echo CHtml::encode($category['description']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="category-actions">
                    <a href="<?php echo $this->createUrl('site/auditcategories', array('edit' => $category['id'])); ?>" class="btn btn-xs btn-primary">
                        <i class="glyphicon glyphicon-pencil"></i> <?=t('Edit')?>
                    </a>
                    <a href="<?php echo $this->createUrl('site/auditcategories', array('delete' => $category['id'])); ?>" class="btn btn-xs btn-danger" 
                       onclick="return confirm('Are you sure you want to delete this category and all its subcategories?');">
                        <i class="glyphicon glyphicon-trash"></i>  <?=t('Delete')?>
                    </a>
                </div>
            </div>
            <?php if(!empty($category['children'])): ?>
                <?php $this->renderPartial('_categoryTree', array('categories' => $category['children'])); ?>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
