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
            <?= $this->Html->link(__('Edit Post Status'), ['action' => 'edit', $postStatus->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Post Status'), ['action' => 'delete', $postStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $postStatus->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Post Statuses'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Post Status'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="postStatuses view content">
            <h3><?= h($postStatus->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($postStatus->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($postStatus->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
