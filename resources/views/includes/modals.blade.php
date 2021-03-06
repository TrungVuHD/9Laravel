<!-- Login Modal -->
<div class="modal fade " id="login-modal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="loginModalLabel">Login</h3>
                <p>Connect with a social network</p>
                <div class="row social-buttons">
                    <div class="col-sm-12 social-btn-wrapper">
                        <a href="{{ url('facebook/redirect') }}" class="social-btn social-btn-fb">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                            <p class="social-btn-txt">
                                Facebook
                            </p>
                        </a>
                    </div>
                    <div class="col-sm-12 social-btn-wrapper">
                        <a href="{{ url('google/redirect') }}" class="social-btn social-btn-gp">
                            <i class="fa fa-google-plus" aria-hidden="true"></i>
                            <p class="social-btn-txt">
                                Google
                            </p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <p>Login with your email address</p>
                <form method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary">Log in</button>
                    <a class="pull-right" href="{{ url('/password/reset') }}">Forgot Password</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Signup Modal -->
<div class="modal fade" id="signup-modal" tabindex="-1" role="dialog" aria-labelledby="signUpModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="signUpModalLabel">Hey there!</h3>
                <p>
                    9LARAVEL is your best source of fun. Share anything you find interesting, get  real responses from people all over the world and discover what makes you code.
                </p>
                <div class="row social-buttons">
                    <div class="col-sm-12 social-btn-wrapper">
                        <a href="{{ url('facebook/redirect') }}" class="social-btn social-btn-fb">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                            <p class="social-btn-txt">
                                Facebook
                            </p>
                        </a>
                    </div>
                    <div class="col-sm-12 social-btn-wrapper">
                        <a href="{{ url('google/redirect') }}" class="social-btn social-btn-gp">
                            <i class="fa fa-google-plus" aria-hidden="true"></i>
                            <p class="social-btn-txt">
                                Google
                            </p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <p>Sign up with your <a href="{{ url('/register') }}">Email Address</a></p>
                <p>Have an account? <a href="{{ url('/login') }}">Login</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-left" id="uploadModalLabel">Upload a Post</h3>
                <p class="text-left">Choose how you want to upload the post</p>
                <div class="row social-buttons">
                    <div class="col-xs-24">
                        <div id="upload-post" class="well">
                            <div class="content">
                                <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                <p>Select image to upload</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="additional-upload-method" data-dismiss="modal" data-toggle="modal" data-target="#upload-url-modal">
                            <div class="content">
                                <i class="fa fa-link" aria-hidden="true"></i>
                                <p>Add from URL</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="additional-upload-method">
                            <div class="content">
                                <a target="_blank" href="http://memeful.com/generator">
                                    <i class="fa fa-paint-brush" aria-hidden="true"></i>
                                    <p>Make a meme</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="set-title-modal" tabindex="-1" role="dialog" aria-labelledby="setTitleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-left" id="setTitleModalLabel">Give your post a title</h3>
                <p class="text-left">An accurate, descriptive title can help people discover your post</p>
            </div>
            <div class="modal-body">
                <div class="top-section">
                    <img id="set-title-image-preview" src="{{ url('img/logo.png') }}" alt="" />
                    <textarea id="upload-post-description" name="description" placeholder="Describe your post"></textarea>
                </div>
                <div class="form-group">
                    <label for="upload-nsfw-input">
                        This post is Not Safe for Work
                    </label>
                    <input type="checkbox" class="right-input" id="upload-nsfw-input" name="nsfw-input" />
                </div>
                <div class="form-group">
                    <label for="attribbute-input-shown">
                        Attribbute original poster
                    </label>
                    <input type="checkbox" class="right-input" id="attribbute-input-shown" />
                </div>
                <div class="form-group hidden attribute-form-group">
                    <input type="hidden" id="upload-post-url" value="{{ url('upload-post') }}" />
                    <input type="text" id="post-attribute-input" name="attribute-input" placeholder="http://" />
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#upload-modal">Back</button>
                <button class="btn btn-primary validate-set-post" data-dismiss="modal" data-toggle="modal" data-target="#pick-section-modal">Next</button>
            </div>
        </div>
    </div>
</div>

<!-- Pick Section Modal -->
<div class="modal fade" id="pick-section-modal" tabindex="-1" role="dialog" aria-labelledby="pickSectionModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-left" id="pickSectionModalLabel">Pick a section</h3>
                <p class="text-left">Submitting to the right section to make sure your post gets the right exposure it deserves!</p>
            </div>
            <div class="modal-body">
                <div class="post-category">
                @foreach ($menu_categories as $cat)
                    <label>
                        <img class="section-image" src="{{ url('img/categories/'.$cat->image) }}" />
                        <h4>{{ $cat->title }}</h4>
                        <input class="upload-post-category" type="radio" name="section" value="{{ $cat->id }}">
                    </label>
                @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#set-title-modal">Back</button>
                <button class="btn btn-primary" id="upload-post-btn">Post</button>
            </div>
        </div>
    </div>
</div>


<!-- Upload from URL Modal -->
<div class="modal fade" id="upload-url-modal" tabindex="-1" role="dialog" aria-labelledby="uploadUrlModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-left" id="uploadUrlModalLabel">Upload from URL</h3>
                <p class="text-left">Type or paste Image URL</p>
            </div>
            <div class="modal-body">
                <input type="text" name="upload-url-input" id="upload-url-input" placeholder="http://" />
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#upload-modal">Back</button>
                <button class="btn btn-primary" id="upload-url-next-btn" data-dismiss="modal" data-toggle="modal" data-target="#set-title-modal">Next</button>
            </div>
        </div>
    </div>
</div>

<!-- Report Modal -->
<div class="modal fade" id="report-modal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-left" id="reportModalLabel">Report Post</h3>
                <p class="text-left">What do you report this post for?</p>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>
                        <input type="radio" class="report-input" name="report_input" value="1" checked="checked">
                        <span>
                            Contains a trademark or copyright violation
                        </span>
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="radio" class="report-input" name="report_input" value="2">
                        <span>
                            Spam, blatant advertising, or solicitation
                        </span>
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="radio" class="report-input" name="report_input" value="3">
                        <span>
                            Contains offensive materials/nudity
                        </span>
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="radio" class="report-input" name="report_input" value="4">
                        <span>
                            Repost of another post on 9GAG
                        </span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="send-report">Submit</button>
            </div>
        </div>
    </div>
</div>

