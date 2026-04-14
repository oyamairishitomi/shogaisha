@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block; color: #1e3a5f; font-size: 2rem; font-weight: bold; text-decoration: none; letter-spacing: 0.05em;">
shogaisha.
</a>
</td>
</tr>
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
