@extends('layouts.master')
@section('wysihtml')
<!-- tiny edit -->
<link href="dist/external/google-code-prettify/prettify.css" rel="stylesheet">
<link href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="https://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<link href="dist/bootstrap-wysiwyg.css" rel="stylesheet">
<script src="dist/external/jquery.hotkeys.js"></script>
<script src="dist/external/google-code-prettify/prettify.js"></script>
<script src="dist/bootstrap-wysiwyg.js"></script>

{{ HTML::script('js/main.js') }}
@stop
@section('content')
<h1>Submit</h1>
<hr>
@if(!$errors->isEmpty())
<div class="alert alert-danger">
    @if(Session::has('message'))
        {{ Session::get('message'); Session::forget('message') }}
    @endif
    <ul>
        @foreach($errors->all() as $error)
        <li> {{ $error }} </li>
        @endforeach
    </ul>
</div>
@endif
{{ Form::open(array(
            'url' => 'submit',
            'method' => 'POST',
            'role' => 'form'
            )) }}
            
<div class="form-group">
    <p>
    <table>
        <tr> 
            <td width="370px;">
                <input type="text" class="form-control" id="link" name="link" placeholder="http://www.youtube.com/watch?v=L3agu30fpl4ys">
            </td> 
            <td style="padding-left: 0.5em;">
                <button id="importlink" type="button" class="btn btn-default" onclick="validateYTLink(document.getElementById('link').value);"><span class="glyphicon glyphicon-import"></span> Import video</button>
            </td>

        </tr>
    </table>
</p>
<div id="preview" style="display: none;">

</div>
</div>
<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Enter title or name">
</div>
{{-- waiting for official replay system
@if(Auth::user()->user_type_id>1)
<div class="form-group">
    <label for="file">Replay File</label>
    <input disabled type="file" id="file" name="file">
    <p class="help-block">Currently disabled due to huge data flow.</p>
</div>
@endif
--}}
<div class="form-group">
    <label for="editor">Description</label>
    
    @include('layouts.wysiwyg-elements')
    
    <div id="editor"></div>
    <input type="hidden" value="None" id="description" name="description">
</div>

<div class="form-group">
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        Champion (optional)
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                    {{--<p>
                    <a href="javascript:;" id="clearlink">Remove selection</a>
                    </p>--}}
                    @include('other.champselection')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">

    <table>
        <tr>
            <td><label for="tags">Category</label></td>
            <td><label for="tags" style="padding-left: 1em;">Tags</label></td>
        </tr>
        <tr>
            <td style="padding-right: 0.5em;">
                <select class="form-control" style="width: 110px;" name="category">
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>                
            </td>
            <td style="padding-left: 1em; width:100%">
                <input type="text" class="form-control" id="tags" name="tags" placeholder="Pentakill, Yasuo, ...">
            </td> 
        </tr>
    </table>
</div>
<hr>
<button type="submit" class="btn btn-primary btn-lg" onclick="javascript:document.getElementById('description').value = document.getElementById('editor').innerHTML;">Submit for verification</button>

{{ Form::close() }}
<br />
@stop
@section('jsfooter')
<script>
    $(function() {
        function initToolbarBootstrapBindings() {
            var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                'Times New Roman', 'Verdana'],
                    fontTarget = $('[title=Font]').siblings('.dropdown-menu');
            $.each(fonts, function(idx, fontName) {
                fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
            });
            $('a[title]').tooltip({container: 'body'});
            $('.dropdown-menu input').click(function() {
                return false;
            })
                    .change(function() {
                        $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
                    })
                    .keydown('esc', function() {
                        this.value = '';
                        $(this).change();
                    });

            $('[data-role=magic-overlay]').each(function() {
                var overlay = $(this), target = $(overlay.data('target'));
                overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
            });
            if ("onwebkitspeechchange"  in document.createElement("input")) {
                var editorOffset = $('#editor').offset();
                $('#voiceBtn').css('position', 'absolute').offset({top: editorOffset.top, left: editorOffset.left + $('#editor').innerWidth() - 35});
            } else {
                $('#voiceBtn').hide();
            }
        }
        ;
        function showErrorAlert(reason, detail) {
            var msg = '';
            if (reason === 'unsupported-file-type') {
                msg = "Unsupported format " + detail;
            }
            else {
                console.log("error uploading file", reason, detail);
            }
            $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
                    '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
        }
        ;
        initToolbarBootstrapBindings();
        $('#editor').wysiwyg({fileUploadError: showErrorAlert});
        window.prettyPrint && prettyPrint();
    });
</script>
{{ HTML::script('dist/js/bootstrap.min.js') }}

{{ HTML::style('/dist/image-picker/image-picker-champions.css') }}
{{ HTML::script('/dist/image-picker/image-picker.min.js') }}
<script type="text/javascript">
    
    $('#clearlink').click(function() {
        $("option:selected").removeAttr("selected");
        $("div").removeClass("selected");
    });
    
    $("#champs").imagepicker();

    $('.togglefilters').click(function() {
            $('.filters').toggle('fast');
    });
    
</script>
@stop
