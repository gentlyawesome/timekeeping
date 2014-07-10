<?foreach ($crud as $key => $data):?>
    
  <?
    $data = (object)$data;

    $attr = $data->attr;
    if(isset($attr['class'])){
      $attr['class'] .= " form-control input-md";
    }else{
      $attr['class'] = "form-control input-md";
    }

    #CHECK IF READYONLY(EDIT) OR NOT(ADD)
    if(isset($view_only) && $view_only){
      $readonly = "readonly";
      $disabled = "disabled";
      $attr['readonly'] = $readonly;
      $attr['disabled'] = $disabled;
    }else{
      $readonly = "";
      $disabled = "";
    }

    $xfield = $data->field;

    $attr['value'] = set_value($attr['name'],isset($edit_record->$xfield)?$edit_record->$xfield:'');
  ?>

  <?if($data->type=="text"):?>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-2 control-label" for="textinput"><?=$data->label?></label>  
      <div class="col-md-6">
      
      <?=form_input($attr);?>

      <?if(isset($data->help) && $data->help ):?>
        <span class="help-block"><?=$data->help?></span>  
      <?endif;?>

      </div>
    </div>

  <?elseif($data->type=="password"):?>
    <?
      $attr['type'] = 'password';
    ?>
    <!-- Text Password-->
    <div class="form-group">
      <label class="col-md-2 control-label" for="textinput"><?=$data->label?></label>  
      <div class="col-md-6">
      
      <?=form_input($attr);?>

      <?if(isset($data->help) && $data->help ):?>
        <span class="help-block"><?=$data->help?></span>  
      <?endif;?>

      </div>
    </div> 

  <?elseif($data->type=="select"):?>
    <!-- SELECT OPTION-->
    <?
      $xattr = "";
      foreach ($attr as $key => $value) {
        if($key != "name"){
          $xattr .= " $key = '$value' ";
        }
      }

    ?>
    <div class="form-group">
      <label class="col-md-2 control-label" for="textinput"><?=$data->label?></label>  
      <div class="col-md-6">
      
      <?=form_dropdown($attr['name'], $data->select_option,$attr['value'],$xattr);?>

      <?if(isset($data->help) && $data->help ):?>
        <span class="help-block"><?=$data->help?></span>  
      <?endif;?>

      </div>
    </div>

   <?elseif($data->type=="date"):?>
    <!-- Text Date-->
    <div class="form-group">
      <label class="col-md-2 control-label" for="textinput"><?=$data->label?></label>  
      <div class="col-md-6">
      
      <?=form_input($attr);?>

      <?if(isset($data->help) && $data->help ):?>
        <span class="help-block"><?=$data->help?></span>  
      <?endif;?>

      </div>
    </div>   

  <?else:?>
  <?endif;?>
<?endforeach;?>