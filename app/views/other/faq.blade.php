@extends('layouts.master')
@section('content')
<h1>FAQ <small>Frequently Asked Questions</small></h1>
<hr>
<div class="panel-group" id="accordion">
    {{--<div class="page-header"><h4>General</h4></div>--}}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseMinusOne">
                    What is {{ Lop::webname }} ?
                </a>
            </h4>
        </div>
        <div id="collapseMinusOne" class="panel-collapse collapse">
            <div class="panel-body">
                {{ Lop::webname }} is a website where you can watch <b>daily plays</b> from players all around the world!
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseMinusY">
                    What will I find here, and what content can I submit ?
                </a>
            </h4>
        </div>
        <div id="collapseMinusY" class="panel-collapse collapse">
            <div class="panel-body">
                By <i>play</i> we mean anything cool enough, that isn't a <i>fail</i>! You can submit LCS snippets, your own pentakills, crazy fights, 1v1 situations, funny moments and so on!
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseMinusX">
                    How can I submit <i>my</i> play ?
                </a>
            </h4>
        </div>
        <div id="collapseMinusX" class="panel-collapse collapse">
            <div class="panel-body">
                To do that, you will need account, so go <a href="/registration">here</a>, and after you are done with registration, there is a section under <i>User Area</i> called <i>My Plays</i> where you can submit it.
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseZero">
                    What features do I get upon making a donation ?
                </a>
            </h4>
        </div>
        <div id="collapseZero" class="panel-collapse collapse">
            <div class="panel-body">
                Please check out <a href="/premium">Premium section</a> for detailed information.
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    How can I to get my play to be displayed on homepage ?
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="panel-body">
                Simple! Collect enough score to compete with today's best, and you will make it in no time.<br/>
                Users can give <b>positive</b> or <b>negative</b> rating to your play, and based on it you go up or you go down.
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                    What is Hall of Fame and when it will be available ?
                </a>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse">
            <div class="panel-body">
                Hall of Fame is place where only the best players with astonishing plays will rise.
                It will be available as soon as there are enough contest winners and plays in the database.
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                    Can I watch today's best plays without opening every single one in new tab ?
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse">
            <div class="panel-body">
                Yes, you can. Click on video thumbnail and <i>wild</i> play will appear, together with upvote/downvote buttons!
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                    How can I change my avatar ?
                </a>
            </h4>
        </div>
        <div id="collapseFour" class="panel-collapse collapse">
            <div class="panel-body">
                Go to your <a href="/profile">profile</a>, click on your current avatar, modal box will open and you are ready to go.
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                    I'm receiving crazy amount of spam in my inbox. Help!
                </a>
            </h4>
        </div>
        <div id="collapseFive" class="panel-collapse collapse">
            <div class="panel-body">
                No problem, head to <a href="/account">account</a> and add them on your ignore list.
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                    Summoner verification does not work for me ?
                </a>
            </h4>
        </div>
        <div id="collapseSix" class="panel-collapse collapse">
            <div class="panel-body">
                It does, just be sure to <i>save</i> your rune page with given code first and wait few seconds before making request.
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
                    Why is my play going through content validation ?
                </a>
            </h4>
        </div>
        <div id="collapseSeven" class="panel-collapse collapse">
            <div class="panel-body">
                If your play gets reported from multiple users for non-related content, it will get temporarily disabled until it's content is verified by our staff.
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseEight">
                    How can I get access to API ?
                </a>
            </h4>
        </div>
        <div id="collapseEight" class="panel-collapse collapse">
            <div class="panel-body">
                We are currently not giving out keys by request, sorry. However, we will make an announcement when we decide so.
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseNine">
                    I tried to contact you, but with no success. What to do next ?
                </a>
            </h4>
        </div>
        <div id="collapseNine" class="panel-collapse collapse">
            <div class="panel-body">
                Give it another try <a href="/contact">here</a>. Your message maybe got stuck in spam folder.
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTen">
                    Error Codes - what do they mean !?
                </a>
            </h4>
        </div>
        <div id="collapseTen" class="panel-collapse collapse">
            <div class="panel-body">
                <strong>401</strong> - You are not authorized to access. Login may fix the problem.
                <br>
                <strong>404</strong> - Requested page does not exists. Check URL again.
                <br>
                <strong>500</strong> - Invalid request to server, couldn't render a view.
            </div>
        </div>
    </div>
</div>

@stop