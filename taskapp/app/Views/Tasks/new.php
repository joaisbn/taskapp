<!-- default layout -->
<?= $this->extend('layouts/default') ?>

<!-- title -->
<?= $this->section('title') ?>Task<?= $this->endSection() ?>

<!-- content -->
<?= $this->section('content') ?>
<h1>New Task</h1>

<?php if (session()->has('errors')) : ?>
    <ul>
        <?php foreach (session('errors') as $error) : ?>
            <li><?= $error ?></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>

<?= form_open('tasks/create') ?>
<div>
    <label for="description">Description</label>
    <input type="text" name="description" id="description">
</div>

<button>Save</button>
<a href="<?= site_url('tasks') ?>">Cancel</a>
<?= form_close() ?>

<?= $this->endSection() ?>
