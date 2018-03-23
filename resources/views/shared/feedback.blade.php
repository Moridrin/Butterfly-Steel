<?php
/**
 * Created by PhpStorm.
 * User: Phinux
 * Date: 21-3-2018
 * Time: 18:35
 */

//Title = Give your feedback
//User data = Name & email
//Type of feedback = Bug, Feature request, Question, Complaint
//About which service = This.page, Map, editor
//About which issue
//When take the issue take place = Date & Time
//Notes
//May we contact you for more information?
//Related Files
?>
<!-- Modal Trigger -->
<a class="waves-effect waves-light btn modal-trigger" href="#modal1">Modal</a>
<!-- Modal Structure -->
<div id="modal1" class="modal bottom-sheet">
    <form action="/feedback/new" method="post">
        <div class="modal-content">
            <h4>Give your feedback</h4>
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    Please fix the following errors
                </div>
        @endif
        <!-- User: Prefill if signed in -->
            <div class="input-field{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                @if($errors->has('name'))
                    <span class="help-block">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="input-field{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <span class="help-block">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="input-field{{ $errors->has('mayContact') ? ' has-error' : '' }}">
                <label for="mayContact">
                    <input type="checkbox" id="mayContact" name="mayContact">
                    <span>May we contact you for more information?</span>
                </label>
                @if($errors->has('mayContact'))
                    <span class="help-block">{{ $errors->first('mayContact') }}</span>
                @endif
            </div>
            <!-- Feedback meta-->
            <div class="input-field{{ $errors->has('feedbackType') ? ' has-error' : '' }}">
                <label for="feedbackType">Type of feedback</label>
                <input type="radio" class="form-control" id="feedbackType" name="feedbackType"
                       value="{{ old('feedbackType') }}">
                @if($errors->has('feedbackType'))
                    <span class="help-block">{{ $errors->first('feedbackType') }}</span>
                @endif
            </div>
            <div class="input-field{{ $errors->has('service') ? ' has-error' : '' }}">
                <label for="service">About which service</label>
                <select name="service" class="form-control" id="service">
                    <option value="" disabled selected>Choose your option</option>
                    <option value="website">Website</option>
                    <option value="map">Map</option>
                    <option value="editor">Map Editor</option>
                    <option value="account">Account</option>
                </select>
                @if($errors->has('service'))
                    <span class="help-block">{{ $errors->first('service') }}</span>
                @endif
            </div>
            <!-- Feedback description -->
            <div class="input-field{{ $errors->has('description') ? ' has-error' : '' }}">
                <label for="description">Description</label>
                <textarea class="form-control materialize-textarea" id="description"
                          name="description">{{ old('description') }}</textarea>
                @if($errors->has('description'))
                    <span class="help-block">{{ $errors->first('description') }}</span>
                @endif
            </div>
            <div class="input-field{{ $errors->has('fileInput') ? ' has-error' : '' }}">
                <label for="fileInput">Related Files</label>
                <input type="file" class="form-control" id="fileInput" name="fileInput">
                @if($errors->has('fileInput'))
                    <span class="help-block">{{ $errors->first('fileInput') }}</span>
                @endif
            </div>
            <!-- Submit -->
            <button type="submit" class="btn btn-default">Submit</button>
        </div>
    </form>
</div>