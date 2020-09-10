<!-- Iterates over all sidebar items-->
  <li class="nav-heading ">
     <span><?php echo $menuname?></span>
  </li>
  <?php
  /* Varre os itens do menu */
  foreach ($menu as $item){
  	/* Captura todos os subitens do item principal */
    $items_child = Segmenu_model::getByParent($item->nidtbxmen);
  ?>
  <li class="<?php echo $this->uri->segment(1)==$item->ccontroller||$this->uri->segment(2)==$item->ccontroller ? "active":""?> ">
  	<?php
  	if (count($items_child) > 0){
  	?>
     <a href="#submenu<?php echo $item->nidtbxmen?>" title="<?php echo $item->cdescrimenu?>" data-toggle="collapse">
        <em class="fa <?php echo $item->cicone?>"></em>
        <span><?php echo $item->cdescrimenu?></span>
     </a>
     <?php
	 ?>
     <ul id="submenu<?php echo $item->nidtbxmen?>" class="nav sidebar-subnav collapse<?php echo $this->uri->segment(1)==$item->ccontroller ? " in":""?>">
        <li class="sidebar-subnav-header"><?php echo $item->cdescrimenu?></li>
        <?php
        foreach ($items_child as $item_child){
        	/* Verifica se o item da iteração é o contrlador que está aberto */
        	$active = false;
        	if ( $this->uri->segment(1) == $item_child->ccontroller && $this->uri->segment(2) == $item_child->cmethod){
        		$active = true;
        	} elseif ( $this->uri->segment(1)."/".$this->uri->segment(2) == $item_child->ccontroller && $this->uri->segment(3) == $item_child->cmethod ) {
        		$active = true;
        	}
        ?>
        <li class="<?php echo $active ? "active":""?> ">
           <a href="<?php echo makeUrl($item_child->ccontroller,$item_child->cmethod,$item_child->cparameters)?>" title="<?php echo $item_child->cdescrimenu?>">
              <span><?php echo $item_child->cdescrimenu?></span>
           </a>
        </li>
        <?php
		}
	  ?>
	  </ul>
	  <?php
	} else {
  	?>
     <a href="<?php echo makeUrl($item->ccontroller,$item->cmethod,$item->cparameters)?>" title="<?php echo $item->cdescrimenu?>">
        <em class="fa <?php echo $item->cicone?>"></em>
        <span><?php echo $item->cdescrimenu?></span>
     </a>
     <?php		
	}
	?>
	</li>
	<?php
  }
  ?>
   <!-- END sidebar nav-->