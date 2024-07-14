<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scientia</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="tabs tabs-lifted px-5 pt-5" role="tablist">
        <input class="tab" name="tabs" type="radio" role="tab" aria-label="Text"
            @if (!isset($checked) || $checked == 'text') checked="checked" @endif>
        <div class="tab-content bg-base-100 border-base-300 rounded-box p-5" role="tabpanel">
            <form class="grid grid-cols-1 gap-5" action="search" method="GET" autocomplete="off">
                @csrf
                <label class="form-control">
                    <input class="input input-bordered @error('title') input-error @enderror" name="title"
                        type="text" value="{{ request()->input('title', old('title')) }}" placeholder="Title">
                    @error('title')
                        <span class="label label-text-alt text-red-500">{{ $message }}</span>
                    @enderror
                </label>
                <label class="form-control">
                    <textarea class="textarea textarea-bordered @error('abstract') textarea-error @enderror" name="abstract"
                        placeholder="Abstract">{{ request()->input('abstract', old('abstract')) }}</textarea>
                    @error('abstract')
                        <span class="label label-text-alt text-red-500">{{ $message }}</span>
                    @enderror
                </label>
                <label class="form-control">
                    <input class="input input-bordered @error('top_n') input-error @enderror" name="top_n"
                        type="number" value="{{ request()->input('top_n', old('top_n')) }}"
                        placeholder="Result amount">
                    @error('top_n')
                        <span class="label label-text-alt text-red-500">{{ $message }}</span>
                    @enderror
                </label>
                <button class="btn" type="submit">Search</button>
            </form>
        </div>
        <input class="tab" name="tabs" type="radio" role="tab" aria-label="PDF"
            @if (isset($checked) && $checked == 'pdf') checked="checked" @endif>
        <div class="tab-content bg-base-100 border-base-300 rounded-box p-5" role="tabpanel">
            <form class="grid grid-cols-1 gap-5" action="search" method="POST" enctype="multipart/form-data"
                autocomplete="off">
                @csrf
                <label class="form-control">
                    <input class="file-input file-input-bordered @error('file') file-input-error @enderror"
                        name="file" type="file" accept="application/pdf">
                    @error('file')
                        <span class="label label-text-alt text-red-500">{{ $message }}</span>
                    @enderror
                </label>
                <label class="form-control">
                    <input class="input input-bordered @error('top_n') input-error @enderror" name="top_n"
                        type="number" value="{{ request()->input('top_n', old('top_n')) }}"
                        placeholder="Result amount">
                    @error('top_n')
                        <span class="label label-text-alt text-red-500">{{ $message }}</span>
                    @enderror
                </label>
                <button class="btn" type="submit">Search</button>
            </form>
        </div>
    </div>
    @if (isset($result) && count($result) > 0)
        <div class="px-5 pt-5">
            @foreach ($result as $i)
                <table class="table-auto">
                    <tbody>
                        <tr>
                            <td class="font-bold align-top">Title</td>
                            <td class="text-justify">{{ $i['title'] }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold align-top">Abstract</td>
                            <td class="text-justify">{{ $i['abstract'] }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold align-top whitespace-nowrap">Document Type</td>
                            <td class="text-justify">{{ $i['document_type'] }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold align-top">Subject</td>
                            <td class="text-justify">{{ $i['subject'] }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold align-top">Unit Field</td>
                            <td class="text-justify">{{ $i['unit_field'] }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold align-top">User ID</td>
                            <td class="text-justify">{{ $i['user_id'] }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold align-top">Date Deposited</td>
                            <td class="text-justify">{{ $i['date_deposited'] }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold align-top">Last Modified</td>
                            <td class="text-justify">{{ $i['last_modified'] }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold align-top">Similarity</td>
                            <td class="text-justify">{{ round($i['similarity'], 2) }}%</td>
                        </tr>
                        <tr>
                            <td class="font-bold align-top">URI</td>
                            <td class="text-justify">
                                <a class="underline" href="{{ $i['url'] }}">
                                    {{ $i['url'] }}
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr class="h-px my-8">
            @endforeach
        </div>
    @endif
</body>

</html>
