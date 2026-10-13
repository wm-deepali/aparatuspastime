<tr>
    <td><input type="number" step="0.01" name="slabs[{{ $i }}][min]" class="field-input" value="{{ $slab->min_order_value ?? '' }}"></td>
    <td><input type="number" step="0.01" name="slabs[{{ $i }}][max]" class="field-input" value="{{ $slab->max_order_value ?? '' }}"></td>
    <td><input type="number" step="0.01" name="slabs[{{ $i }}][local]" class="field-input" value="{{ $slab->local_charge ?? '' }}"></td>
    <td><input type="number" step="0.01" name="slabs[{{ $i }}][state]" class="field-input" value="{{ $slab->state_charge ?? '' }}"></td>
    <td><input type="number" step="0.01" name="slabs[{{ $i }}][inter]" class="field-input" value="{{ $slab->inter_charge ?? '' }}"></td>
    <td><button type="button" class="btn-danger-soft" onclick="this.closest('tr').remove()"><i class="fa fa-trash"></i></button></td>
</tr>