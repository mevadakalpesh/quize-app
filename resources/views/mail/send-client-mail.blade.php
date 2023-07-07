<x-mail::message>

{{ $data->body }}

<x-mail::button url="https://api.whatsapp.com/send?phone=+91 84014
31310&text=Hay.!
Your expertise needed to boost business growth! Let's discuss about my website , 
Thanks!" style="background-color:none;text-align: center;">
Connect with Me for Growth and Success!
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

