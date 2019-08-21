<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <title>Słówka</title>
  </head>
<body>
    <div class="container btn btn-info">{{$listName}}</div>
    <table class="table">
        <tr class="thead-inverse">
            <th scope="row">L.p.</th>
            <th scope="row">Polskie słowo</th>
            <th scope="row">Tłumaczenie</th>
            <th scope="row">Nauczone?</th>
        </tr>
             <?php $i = 1; ?>
            @foreach($nativeWordsArray as $word)
            <tr>
            <th>{{ $i }}</th> 
             <td>{{ $nativeWordsArray[$i - 1] }}</th>
            <td>{{ $foreignWordsArray[$i - 1] }}</th>   
            <td></th>
        </tr>
         <?php $i++;?> 
        @endforeach
    </table>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>  