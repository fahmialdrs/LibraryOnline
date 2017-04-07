<!DOCTYPE html>
<html>
<head>
    <title>@yield("title")</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>    
    <div class="container">
        <div class="">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-area">
                        {!! Form::open(['url' => 'post/save', 'files'=>true]) !!}
                            <div class="text-center">
                                <h3>Form Berita</h3>
                            </div>
                            <hr>
                            <br>
                            <div class="form-group">
                                {!! Form::label('tanggal', 'Tanggal', ['class' => 'awesome']) !!}
                                {!! Form::date('tanggal',\Carbon\Carbon::now()) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('judul', 'Judul', ['class' => 'awesome']) !!}
                                {!! Form::text('isi') !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('isi', 'isi', ['class' => 'awesome']) !!}
                                {!! Form::textarea('isi') !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('foto', 'foto', ['class' => 'awesome']) !!}
                                {!! Form::file('foto') !!}
                            </div>
                            {!! Form::submit('Create New Task', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <a href="{{route('show')}}">BACK</a>        
        </div>
        <!-- <div class="col-md-5">
            <div class="form-area">  
                <form role="form" method="POST" action="">
                <br style="clear:both">
                            <h3 style="margin-bottom: 25px; text-align: center;">Contact Form</h3>
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="judul" placeholder="Judul" required>
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control" id="mobile" name="tanggal" required>
                            </div>
                            <div class="form-group">
                            <textarea class="form-control" type="textarea" id="message" name="isi" placeholder="Message" maxlength="140" rows="7"></textarea>
                                <span class="help-block"><p id="characterLeft" class="help-block ">You have reached the limit</p></span>                    
                            </div>
                    
                <button type="button" id="submit" name="submit" class="btn btn-primary pull-right">Submit Form</button>
                </form>
            </div>
        </div> -->
        </div>
        
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/style.js') }}"></script>
</body>
</html>

