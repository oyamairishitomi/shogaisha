@extends('layouts.app')
@section('content')

<main class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-8">ユーザー一覧</h1>
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b">
                <th class="text-left py-2">ID</th>
                <th class="text-left py-2">ハンドル名</th>
                <th class="text-left py-2">メール</th>
                <th class="text-left py-2">IP</th>
                <th class="text-left py-2">権限</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b">
                <td class="py-2">{{ $user->id }}</td>
                <td class="py-2">{{ $user->handle_name }}</td>
                <td class="py-2">{{ $user->email }}</td>
                <td class="py-2">{{ $user->ip_address }}</td>
                <td class="py-2">{{ $user->authority === 0 ? '管理者' : 'ユーザー' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</main>

@endsection
