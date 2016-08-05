<div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
        @if(Auth::user()->user_type_id>1)
        <div class="btn-group">
            <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font" <?php if(Auth::user()->user_type_id==1) { echo "onclick=\"javascript: alert('Only available for premium users.');\"";}  ?>><i class="icon-font"></i><b class="caret"></b></a>
            @if(Auth::user()->user_type_id>1)
            <ul class="dropdown-menu">
            </ul>
            @endif
        </div>
        <div class="btn-group">
            <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size" <?php if(Auth::user()->user_type_id==1) { echo "onclick=\"javascript: alert('Only available for premium users.');\"";}  ?>><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
            @if(Auth::user()->user_type_id>1)
            <ul class="dropdown-menu">
                <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
                <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
                <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
            </ul>
            @endif
        </div>
        @endif
        <div class="btn-group">
            <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
            <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
            <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
            <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
        </div>
        <div class="btn-group">
            <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
            <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
            <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
            <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
        </div>
        <div class="btn-group">
            <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
            <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
            <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
            <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
        </div>
        <div class="btn-group">
            <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
            <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
        </div>
    </div>