<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container py-4">
        <h3>Haberler</h3>
        <form action="{{ url('/') }}">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>Tarih</label>
                        <div class="input-group">
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>Coinler</label>
                        <select name="currency" class="form-select">
                            <option value="">Seçim yapılmadı</option>
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}" @selected(request('currency') == $currency->id)>{{ $currency->code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group text-end my-2">
                        <button type="submit" class="btn btn-success">Filtrele</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Başlık</th>
                                <th>Tarih</th>
                                <th>Coin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($news as $_news)
                            <tr>
                                <td>
                                    <a href="{{ $_news->url }}" target="_blank">{{ $_news->title }}</a>
                                </td>
                                <td>
                                    {{ $_news->published_at->format('d.m.y H:i:s') }}
                                </td>
                                <td>
                                    {{ implode(', ', $_news->currencies->pluck('code')->toArray()) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2">
                                    Kayıt yok
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $news->links() }}
                </div>
            </div>
        </div>
    </div>

</body>

</html>