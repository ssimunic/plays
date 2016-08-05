function addslashes(str) 
{
	str=str.replace(/\'/g,'\\\'');
	str=str.replace(/\"/g,'\\"');
	str=str.replace(/\\/g,'\\\\');
	str=str.replace(/\0/g,'\\0');
	return "'"+str+"'";
}

function httpGet(theUrl)
  {
    var xmlHttp = null;

    xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, false );
    xmlHttp.send( null );
    return xmlHttp.responseText;
  }

function validateYTLink(link)
{
    if (link.indexOf('http://www.youtube.com/watch?v=') > -1 
            || link.indexOf('http://youtube.com/watch?v=') > -1
            || link.indexOf('https://www.youtube.com/watch?v=') > -1
            || link.indexOf('https://youtube.com/watch?v=') > -1)
    {
        var ytidparams = link.split('?v=');
        var ytid = ytidparams[1].split('&', 1);
        
        var response = httpGet('http://gdata.youtube.com/feeds/api/videos/' + ytid);
        
        if(response==='Invalid id' || response==='Video not found')
        {
            alert('Invalid YouTube video ID.');
        }
        else
        {
        document.getElementById('preview').style.display = 'block';
        document.getElementById('preview').innerHTML = '<label>Preview</label><p class="youtube_video_submit"><object width="560" height="315"><param name="movie" value="//www.youtube.com/v/'+ytid+'?version=3&amp;hl=hr_HR"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed {{--class="youtube_video_submit_embed"--}} src="//www.youtube.com/v/'+ytid+'?version=3&autohide=1&showinfo=0&rel=0&iv_load_policy=3" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true"></embed></object></p>';
       }
    } 
    else 
    {
        alert('Invalid URL.');
        return false;
    }
}

function ConfirmDelete()
{
    var x = confirm("Are you sure you want to delete this play ?");
    if (x)
    {
        document.getElementById('delete').value = 'true';
        return true;
    }
    else
    {
      return false;
    }
}