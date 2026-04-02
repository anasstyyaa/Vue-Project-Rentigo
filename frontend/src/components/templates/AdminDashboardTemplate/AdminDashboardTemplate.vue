<template>
  <div class="min-h-screen bg-gray-50/50">
    <header class="bg-white border-b border-gray-200 px-8 py-6">
      <div class="max-w-7xl mx-auto flex justify-between items-center">
        <slot name="header"></slot>
      </div>
    </header>

    <main class="max-w-7xl mx-auto px-8 py-10 space-y-8">
      <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <slot name="stats"></slot>
      </section>

      <section>
        <slot name="content"></slot>
      </section>
    </main>
  </div>
</template>