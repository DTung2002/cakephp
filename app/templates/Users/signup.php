<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

?>

<div class="users form">

    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Sign up') ?></legend>
                <?php
                    echo $this->Form->control('email');
                    echo $this->Form->control('username');
                    echo $this->Form->control('password');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
