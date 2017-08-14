<?php ?>
<tr id="ordered-product-id-">
    <td>1</td>
    <td>
      <input type="text" class="form-control product_code" name="product_code[]" value="<?= $data["product_code"];?>" disabled="disabled" />
      <input type="hidden" class="product_id" name="product_id[]" value="<?= $data["id"];?>"/>
    </td>
    <td><input type="text" class="form-control name" name="name[]" value="<?= $data["name"];?>" disabled="disabled" /></td>
    <td><input type="number" class="form-control quantity" name="quantity[]" value="1" /></td>
    <td><input type="number" class="form-control price" name="price[]" value="<?=$data["price"];?>" /></td>
    <td><input type="number" class="form-control weight" name="weight[]" value="<?=$data["weight"];?>" /></td>
    <td class="action">
      <a class="btn btn-white remove-product" href="javascript:void(0);"><i class="fa fa-trash-o"></i></a>
    </td>
</tr>
