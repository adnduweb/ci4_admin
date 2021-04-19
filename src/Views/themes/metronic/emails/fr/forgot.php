<p>Quelqu'un a demandé une réinitialisation de votre mot de passe à cette adresse e-mail pour l'application <?= base_url() ?>.</p>

<p>Pour réinitialiser le mot de passe, utilisez ce code ou cette URL et suivez les instructions.</p>

<p>Votre code: <?= $hash ?></p>

<p>Allez sur le site <a href="<?= base_url(env("site_area") . '/reset-password') . '?token=' . $hash ?>">pour réinitialiser votre mot de passe</a>.</p>

<br>

<p>Si vous n'avez pas demandé de réinitialisation de mot de passe, vous pouvez ignorer cet e-mail en toute sécurité.</p>
Le <?= date('d-m-Y H:i:s'); ?>
