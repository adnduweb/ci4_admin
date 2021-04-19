 <?php if (!empty($image->custom)) { ?>
     <?php foreach ($image->custom as $k => $v) { ?>
         <div style="justify-content:space-between;display:flex" class="kt-avatar">
             <div>
                 <strong>Dimension</strong> : <a target="_blank" href="/uploads/custom/<?= $v; ?>"><?= $k; ?>px</a>
             </div>
             <div>
                 <a class="deleteFileCustom delete-attachment" data-id-media="<?= $image->getIdMedia(); ?>" data-format="<?= $v ?>" href="javascript:;"><?= lang('Core.delete'); ?></a></strong>
             </div>
         </div>
     <?php } ?>
 <?php } ?>
