@extends('layouts.layout')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-12 text-gray-200">
        <h1 class="text-3xl font-bold mb-6">Terms of Service</h1>
        <p class="mb-4">Last updated: {{ date('F d, Y') }}</p>

        <p class="mb-4">
            Welcome to <strong>Clash Intel</strong>. By using our website, you agree to the following terms and conditions.
            Please read them carefully.
        </p>

        <h2 class="text-xl font-semibold mt-6 mb-2">1. Use of Service</h2>
        <ul class="list-disc ml-6 space-y-1">
            <li>This website is for informational purposes only.</li>
            <li>You may search for Clash of Clans players, clans, wars, and rankings using the official Supercell API data.</li>
            <li>You agree not to abuse or overload the service with excessive requests.</li>
        </ul>

        <h2 class="text-xl font-semibold mt-6 mb-2">2. No Guarantee</h2>
        <p class="mb-4">
            We strive to keep our data accurate and up-to-date, but we cannot guarantee that all information is always correct.
            Supercell API limitations or downtime may cause delays or missing data.
        </p>

        <h2 class="text-xl font-semibold mt-6 mb-2">3. Intellectual Property</h2>
        <p class="mb-4">
            Clash of Clans and all related content are trademarks of Supercell.  
            This site is not affiliated with, endorsed, sponsored, or specifically approved by Supercell.
        </p>

        <h2 class="text-xl font-semibold mt-6 mb-2">4. Limitation of Liability</h2>
        <p class="mb-4">
            We are not liable for any damages or losses resulting from the use of this service, including but not limited to
            data inaccuracies, downtime, or third-party actions.
        </p>

        <h2 class="text-xl font-semibold mt-6 mb-2">5. Changes to These Terms</h2>
        <p class="mb-4">
            We may update these terms at any time without prior notice. Continued use of the service means you accept the updated terms.
        </p>

        <h2 class="text-xl font-semibold mt-6 mb-2">6. Contact</h2>
        <p>If you have any questions, you can contact us at: <a href="mailto:reymartinagluya8@email.com" class="text-blue-400 hover:underline">reymartinagluya8@email.com</a></p>
    </div>
@endsection
