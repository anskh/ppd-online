<?php

/**
 * @var $this \CodeIgniter\View\View
 */
$this->extend('frontend/template');

$this->section('window_title');
echo site_config('windows_title');
$this->endSection();

$this->section('breadcrumb');
?>
<section class="pathway">
    <div class="container">
        <nav aria-label="breadcrumb" class="navbar-dark">
            <div class="row">
                <div class="col-12">
                    <ol class="nav py-2" style="background-color: transparent!important;">
                        <li class="breadcrumb-item text-light"><a href="<?= site_url(route_to('home')) ?>"><?= lang('Client.menu.home') ?></a></li>
                        <li class="breadcrumb-item text-light current"><a href="#"><?= lang('Client.menu.newUser') ?></a></li>
                    </ol>
                </div>
            </div>
        </nav>
    </div>
</section>
<?php
$this->endSection();

$this->section('content');
?>
<div class="row py-5">
    <div class="col-12 text-center">
        <h1 class="heading">
            <?php echo lang_replace('Client.login.title', ['%site_name%' => 'PPD-ONLINE']); ?>
        </h1>
    </div>
</div>
<div class="row mb-5 d-flex justify-content-center">
    <!-- Login Box -->
    <div class="col-lg-7">
        <?php
        echo form_open('', [], ['do' => 'submit']);
        if (isset($error_msg)) {
            echo '<div class="alert alert-danger">' . $error_msg . '</div>';
        }
        ?>
        <div class="form-group">
        <label><?php echo lang('Client.form.fullName'); ?></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                </div>
                <input type="text" name="fullname" placeholder="<?php echo lang('Client.form.fullName'); ?>" class="form-control" value="<?php echo set_value('fullname'); ?>">
            </div>
        </div>
        <div class="form-group">
        <label><?php echo lang('Client.form.email'); ?></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                </div>
                <input type="email" name="email" placeholder="<?php echo lang('Client.form.email'); ?>" class="form-control" value="<?php echo set_value('email'); ?>">
            </div>
        </div>
        <div class="form-group">
        <label><?php echo lang('Client.form.phone'); ?></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-phone"></i></span>
                </div>
                <input type="tel" name="phone" placeholder="<?php echo lang('Client.form.phone'); ?>" class="form-control" value="<?php echo set_value('phone'); ?>">
            </div>
        </div>
        <div class="form-group">
            <label><?php echo lang('Client.form.location'); ?></label>
            <select name="location" class="form-group custom-select" id="location">
                <?php
                $default = set_value('location', (isset($user) ? $user->location : 0));
                foreach ([0 => lang('Client.form.wilayah'), 1 => lang('Client.form.other')] as $k => $v) {
                    if ($default == $k) {
                        echo '<option value="' . $k . '" selected>' . $v . '</option>';
                    } else {
                        echo '<option value="' . $k . '">' . $v . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group mb-5">
            <label><?php echo lang('Client.form.captcha');?></label>
            <div class="input-group">
                <?= captcha()?>
                <input type="text" name="captcha" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3 mb-3">
                    <button class="btn btn-primary btn-block"><?php echo lang('Client.login.button'); ?></button>
                </div>
                <div class="col-auto text-right">
                    <a href="<?php echo site_url(route_to('getlogin')); ?>"><?php echo lang('Client.login.registeredUser'); ?></a>
                </div>
            </div>
        </div>
        <?php
        echo form_close();
        ?>
    </div>
    <!-- End Login Box -->
</div>

<?php
$this->endSection();
