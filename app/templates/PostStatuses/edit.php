<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PostStatus $postStatus
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $postStatus->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $postStatus->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Post Statuses'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="postStatuses form content">
            <?= $this->Form->create($postStatus) ?>
            <fieldset>
                <legend><?= __('Edit Post Status') ?></legend>
                <?php
                    echo $this->Form->control('name');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
