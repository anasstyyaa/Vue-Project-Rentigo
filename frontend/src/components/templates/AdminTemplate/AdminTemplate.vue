<template>
  <div class="flex h-screen bg-gray-50 font-sans">
    <aside class="w-64 bg-slate-900 text-white flex-shrink-0 hidden md:flex flex-col">
      <div class="p-6 text-2xl font-bold border-b border-slate-800 text-blue-400">
        Rentigo <span class="text-white text-xs uppercase tracking-widest ml-1">CMS</span>
      </div>
      
      <nav class="overflow-y-auto flex-1 p-4 space-y-2">
        <slot name="sidebar-nav" />
      </nav>

      <div class="p-4 border-t border-slate-800">
        <slot name="sidebar-footer" />
      </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
      <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 z-10">
        <div class="flex items-center">
          <slot name="header-left" />
        </div>
        <div class="flex items-center space-x-4">
          <slot name="header-right" />
        </div>
      </header>

      <main class="flex-1 overflow-y-auto p-8">
        <div class="max-w-7xl mx-auto">
          <slot name="main-content" />
        </div>
      </main>
    </div>
  </div>
</template>