<template>
  <div class="min-h-screen bg-gray-50/50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-8">
      <header class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
        <slot name="header" />
      </header>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <aside class="lg:col-span-4">
          <slot name="sidebar" />
        </aside>

        <main class="lg:col-span-8">
          <slot name="content" />
        </main>
      </div>
    </div>
  </div>
</template>