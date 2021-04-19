 <div class="form_builder" style="margin-top: 25px">
     <div class="row">
         <div class="col-sm-3">
             <nav class="nav-sidebar">
                 <ul class="nav">
                     <li data-compoment="textfield" class="form_bal_textfield">
                         <a href="javascript:;"><i class="fa fa-plus-circle"></i> <?= lang('Core.builder_titre'); ?></a>
                         <div class="compoments compoments_textfield" style="display: none">
                             <?= $this->include('/admin/themes/metronic/__partials/builder/compoments/textfield') ?>
                         </div>
                     </li>
                     <li data-compoment="textareafield" class=" form_bal_textareafield">
                         <a href="javascript:;"><i class="fa fa-plus-circle"></i> <?= lang('Core.builder_texte'); ?> </a>
                         <div class="compoments compoments_textareafield" style="display: none">
                             <?= $this->include('/admin/themes/metronic/__partials/builder/compoments/textareafield') ?>
                         </div>
                     </li>
                     <li data-compoment="imagefield" class="form_bal_imagefield">
                         <a href="javascript:;"><i class="fa fa-plus-circle"></i> <?= lang('Core.builder_image_only'); ?> </a>
                         <div class="compoments compoments_imagefield" style="display: none">
                             <?= $this->include('/admin/themes/metronic/__partials/builder/compoments/imagefield') ?>
                         </div>
                     </li>
                     <li data-compoment="imageCarouselfield" class="form_bal_imageCarouselfield">
                         <a href="javascript:;"><i class="fa fa-plus-circle"></i> <?= lang('Core.builder_image_carousel'); ?> </a>
                         <div class="compoments compoments_imageCarouselfield" style="display: none">
                             <?= $this->include('/admin/themes/metronic/__partials/builder/compoments/imageCarouselfield') ?>
                         </div>
                     </li>
                     <?php if (class_exists('\Adnduweb\Ci4_blog\Controllers\Admin\AdminPostsController')) { ?>
                         <li data-compoment="actufield" class="form_bal_actufield">
                             <a href="javascript:;"><i class="fa fa-plus-circle"></i> <?= lang('Core.builder_actualites'); ?> </a>
                             <div class="compoments compoments_actufield" style="display: none">
                                 <?= $this->include('\Adnduweb\Ci4_blog\Views\admin\themes\metronic\__partials\builder\compoments\actufield') ?>
                             </div>
                         </li>
                     <?php } ?>
                     <?php if (class_exists('\Adnduweb\Ci4_diaporama\Controllers\Admin\AdminDiaporamasController')) { ?>
                         <li data-compoment="diaporamafield" class="form_bal_diaporamafield">
                             <a href="javascript:;"><i class="fa fa-plus-circle"></i> <?= lang('Core.builder_diaporama'); ?> </a>
                             <div class="compoments compoments_diaporamafield" style="display: none">
                                 <?= $this->include('\Adnduweb\Ci4_diaporama\Views\admin\themes\metronic\__partials\builder\compoments\diaporamafield') ?>
                             </div>
                         </li>
                     <?php } ?>
                     <?php if (class_exists('\Adnduweb\Ci4_formulaire\Controllers\Admin\AdminFormulaireController')) { ?>
                         <li data-compoment="formulairefield" class="form_bal_formulairefield">
                             <a href="javascript:;"><i class="fa fa-plus-circle"></i> <?= lang('Core.builder_actualites'); ?> </a>
                             <div class="compoments compoments_formulairefield" style="display: none">
                                 <?= $this->include('\Adnduweb\Ci4_formulaire\Views\admin\themes\metronic\__partials\builder\compoments\formulairefield') ?>
                             </div>
                         </li>
                     <?php } ?>
                 </ul>
             </nav>
         </div>
         <div class="col-md-9 bal_builder">
             <div class="form_builder_area">
                 <?php if (isset($form->builders) && !empty($form->builders)) { ?>
                     <?php foreach ($form->builders as $builder) { ?>
                         <?php if (in_array($builder->type, ['textfield', 'textareafield', 'imagefield'])) { ?>
                             <?= view('/admin/themes/metronic/__partials/builder/compoments/' . $builder->type, ['builder' => $builder]) ?>
                         <?php } ?>
                         <?php if ($builder->type == 'actufield') { ?>
                             <?= view('\Adnduweb\Ci4_blog\Views\admin\themes\metronic\__partials\builder\compoments\\' . $builder->type, ['builder' => $builder]) ?>
                         <?php } ?>
                         <?php if ($builder->type == 'diaporamafield') { ?>
                             <?= view('\Adnduweb\Ci4_diaporama\Views\admin\themes\metronic\__partials\builder\compoments\\' . $builder->type, ['builder' => $builder]) ?>
                         <?php } ?>
                         <?php if ($builder->type == 'formulairefield') { ?>
                             <?= view('\Adnduweb\Ci4_formulaire\Views\admin\themes\metronic\__partials\builder\compoments\\' . $builder->type, ['builder' => $builder]) ?>
                         <?php } ?>
                     <?php } ?>
                 <?php } ?>

             </div>
         </div>
     </div>
 </div>