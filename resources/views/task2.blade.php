<!DOCTYPE html>
<html>

<head>
  <link data-require="bootstrap-css@3.1.1" data-semver="3.1.1" rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div>
          <h1>Data export</h1>
          <br>

          <form method="post" class="col-md-6">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="">Array:</label>
              <select name="arr[]" class="form-control" multiple="">
                <option value="option1">option1</option>
                <option value="option2">option2</option>
                <option value="option3">option3</option>
                <option value="option4">option4</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Text:</label>
              <input type="text" name="text" class="form-control" multiple="multiple" />
            </div>
            <div class="form-group">
              <label for="">Number:</label>
              <input type="number" name="num" class="form-control" multiple="multiple" />
            </div>

            <br><br>

            <div class="form-group">
              <label for=""><b>Export type:</b></label>
              <select name="type" class="form-control">
                <option value="json">JSON</option>
                <option value="xml">XML</option>
              </select>
            </div>

            <button type="submit" class="save btn btn-primary">Export</button>
          </form>

        </div>

      </div>
    </div>
  </div>

</body>

</html>
