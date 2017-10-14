<div class="container">
    <nav class="navbar">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">PICHKU</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="/pincode">PinCodes</a></li>
                    <li><a href="/ifsc">IFSC Codes</a></li>
                    <li class="dropdown" hidden style="display: none;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">Dropdown <span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    {if $user->isValid()}
                        {if $user->IS_MOD}
                            <li><a href="?family_id=">New</a></li>
                            <li class="dropdown hide">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">Dropdown <span
                                            class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </li>
                        {/if}
                        <li><a href="/logout">Logout</a>
                        </li>
                    {else}
                        <li>
                            <div class="input-group" style="padding: 18px;">
                                <select id="wishlist" value="" style="min-width: 50px"
                                        onchange="location = this.value;">
                                    <option value=""> --</option>
                                </select>
                            </div>
                        </li>
                        {if isset($page->id) && !empty($page->id)}
                            <li>
                                <div class="input-group" style="padding: 18px;">
                                    <label>Link</label>
                                    <span>
                                    <input value="http://www.pichku.com/product/{$page->id}/0/info.html" readonly
                                           disabled>
                                </span>
                                </div>

                            </li>
                            <li>
                                <div style="padding: 18px;" class="fb-share-button"
                                     data-href="/product/{$page->id}/0/info.html"
                                     data-layout="button_count" data-size="large" data-mobile-iframe="true"><a
                                            class="fb-xfbml-parse-ignore" target="_blank"
                                            href="https://www.facebook.com/sharer/sharer.php?u=%2Fproduct%2F{$page->id}%2F0%2Finfo.html&amp;src=sdkpreparse">Share</a>
                                </div>
                            </li>
                        {/if}
                        <li><a id="create_list" href="/page">Create Page</a>
                        </li>
                    {/if}
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>