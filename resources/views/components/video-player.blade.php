@props(['url'])
<div class="flex justify-center p-4">
    <video controls autoplay width="100%" class="rounded-lg shadow-lg">
        <source src="{{ $url }}" type="video/mp4">
        مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
    </video>
</div>
