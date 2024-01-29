@extends('layouts.admin')

@section('content')
    <div class="containe mt-5">
        <h2>{{ $project->title }}</h2>

        @if ($project->cover_image)
            <div class="mt-4">
                <img src="{{ asset('storage/' . $project->cover_image) }}" alt="">
            </div>
        @else
            <p class="mt-4">Nessuna immagine presente</p>
        @endif

        <div>
            <strong>Tipologia: </strong>
            {{ $project->type ? $project->type->name : 'Nessuna categoria' }}
        </div>

        <div>
            <strong>Tecnologia: </strong>
            @foreach ($project->technologies as $technology)
                <span class="badge" style="background-color: {{ $technology->hex_color }}">{{ $technology->name }}</span>
            @endforeach
            
        </div>

        <div class="mt-4">
            <p>
                <strong>Data:</strong>
                {{ $project->created_at }}
            </p>
        </div>
        <div class="mt-4">
            <p>
                <strong>Slug:</strong>
                {{ $project->slug }}
            </p>
        </div>
        <div class="mt-4">
            <p>
                <strong>Descrizione:</strong>
                {{ $project->description }}
            </p>
        </div>
    </div>
    

@endsection