@extends('layouts.layout')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-12 text-gray-200">
        <h1 class="text-3xl font-bold mb-6">Privacy Policy</h1>
        <p class="mb-4">Last updated: {{ date('F d, Y') }}</p>

        <p class="mb-4">
            This Privacy Policy explains how we handle information when you use <strong>Clash Intel</strong>, our Clash of Clans search tool.
            We respect your privacy and aim to be transparent about any data that may be collected.
        </p>

        <h2 class="text-xl font-semibold mt-6 mb-2">1. Information We Collect</h2>
        <ul class="list-disc ml-6 space-y-1">
            <li>We do <strong>not</strong> require user accounts or personal information.</li>
            <li>When you search for players or clans, we send the search query to the official Clash of Clans API to retrieve results.</li>
            <li>Your IP address may be temporarily logged by our hosting provider for security and analytics purposes.</li>
        </ul>

        <h2 class="text-xl font-semibold mt-6 mb-2">2. How We Use Information</h2>
        <ul class="list-disc ml-6 space-y-1">
            <li>To display search results for players, clans, wars, and rankings.</li>
            <li>To monitor site performance and prevent abuse of the service.</li>
        </ul>

        <h2 class="text-xl font-semibold mt-6 mb-2">3. Cookies & Tracking</h2>
        <p class="mb-4">We may use simple cookies or local storage to remember your UI preferences (e.g., selected tabs). We do not track users across other websites.</p>

        <h2 class="text-xl font-semibold mt-6 mb-2">4. Third-Party Services</h2>
        <p class="mb-4">
            All Clash of Clans data is retrieved from the official <a href="https://developer.clashofclans.com/" class="text-blue-400 hover:underline" target="_blank">Supercell API</a>.  
            We are <strong>not</strong> affiliated with, endorsed, sponsored, or specifically approved by Supercell, and we are not responsible for their services.
        </p>

        <h2 class="text-xl font-semibold mt-6 mb-2">5. Contact</h2>
        <p>If you have questions about this Privacy Policy, you can contact us at: <a href="mailto:reymartinagluya8@email.com" class="text-blue-400 hover:underline">reymartinagluya8@email.com</a></p>
    </div>
@endsection
