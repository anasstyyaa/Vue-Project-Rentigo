<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <header class="w-full bg-white border-b border-gray-100">
      <slot name="header"></slot>
    </header>

    <main class="flex-grow flex items-center justify-center p-6 md:p-12">
      <div class="w-full max-w-md">
        <slot name="form"></slot>
      </div>
    </main>
    
  </div>
</template>
