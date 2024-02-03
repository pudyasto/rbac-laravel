<table class="table table-hover">
    @foreach($module as $val_module)
        @if($val_module->permission && count($val_module->permission) > 0)
        <tr>
            <td>
                <div class="form-group mb-2">
                    <div class="checkbox-inline">
                        <label class="checkbox mb-2" style="cursor: pointer;font-weight: 800;">
                            <input type="checkbox" class="chk-header" name="head-{{ $val_module->uuid }}" data-id="chk-{{ $val_module->uuid }}" value="" />
                            <span></span>
                            {{ $val_module->name }}
                        </label>
                    </div>
                    <div class="checkbox-inline">
                        <div class="row">

                            @foreach($val_module->permission as $val_permission)
                                <div class="col-sm-4 pr-0">
                                    <label class="checkbox" style="cursor: pointer;">
                                        <input type="checkbox" class="chk-{{ $val_module->uuid }}" name="chk-{{ $val_permission->id }}" value="{{ $val_permission->id }}" {{$val_permission->checked}} />
                                        <span></span>
                                        {{$val_permission->name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        @endif
    @endforeach
</table>

<script type="text/javascript">
    $('.chk-header').on('click', function() {
        var clss = $(this).attr("data-id");
        if ($(this).prop("checked") === true) {
            selects(clss);
        } else {
            deSelect(clss)
        }
    });

    function selects(clss) {
        var ele = document.getElementsByClassName(clss);
        for (var i = 0; i < ele.length; i++) {
            if (ele[i].type == 'checkbox')
                ele[i].checked = true;
        }
    }

    function deSelect(clss) {
        var ele = document.getElementsByClassName(clss);
        for (var i = 0; i < ele.length; i++) {
            if (ele[i].type == 'checkbox')
                ele[i].checked = false;

        }
    }
</script>