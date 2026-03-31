<template>
  <div class="min-h-screen bg-gray-50 flex flex-col">
    <header class="w-full bg-white border-b border-gray-100">
      <slot name="header" />
    </header>

    <main class="flex-grow flex items-center justify-center p-4 md:p-8">
      <div class="w-full max-w-2xl">
        <div class="mb-6">
          <slot name="back-button" />
        </div>

        <slot name="booking-form" />
      </div>
    </main>

    <footer class="py-6 text-center text-gray-400 text-sm">
      <slot name="footer">
        © {{ new Date().getFullYear() }} EasyRent - Secure Checkout
      </slot>
    </footer>
  </div>
</template>

