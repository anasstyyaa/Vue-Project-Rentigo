<template>
  <div class="min-h-screen flex flex-col bg-gray-50/50 antialiased">
    <header class="sticky top-0 z-50 w-full bg-white/80 backdrop-blur-md border-b border-gray-100">
      <slot name="header"></slot>
    </header>

    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-12">
      
      <nav v-if="$slots.navigation" class="mb-6">
        <slot name="navigation"></slot>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
        
        <article class="lg:col-span-7 space-y-8 lg:space-y-12">
          <section aria-label="Media Gallery">
            <slot name="visuals"></slot>
          </section>

          <section aria-label="Vehicle Information">
            <slot name="details"></slot>
          </section>
        </article>

        <aside class="lg:col-span-5 lg:sticky lg:top-24 space-y-6">
          <slot name="sidebar"></slot>
          
          <slot name="sidebar-extra"></slot>
        </aside>

      </div>
    </main>

    <footer class="mt-auto border-t border-gray-200 bg-white">
      <slot name="footer"></slot>
    </footer>
  </div>
</template>