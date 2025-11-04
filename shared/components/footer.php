<!-- Mobile Bottom Navigation -->
<footer class="lg:hidden fixed bottom-0 left-0 right-0 z-10 flex items-center justify-around px-2 py-2 bg-white/80 dark:bg-background-dark/80 backdrop-blur-sm border-t border-gray-200 dark:border-gray-800">
    <a @click.prevent="navigateTo('dashboard')"
       :class="currentRoute === 'dashboard' ? 'text-primary' : 'text-gray-600 dark:text-gray-300'"
       class="flex flex-col items-center justify-center gap-1 w-full py-1 rounded-lg cursor-pointer"
       href="#dashboard">
        <span class="material-symbols-outlined">home</span>
        <span class="text-xs font-medium">Ana Sayfa</span>
    </a>
    <a @click.prevent="navigateTo('laboratory')"
       :class="currentRoute === 'laboratory' ? 'text-primary' : 'text-gray-600 dark:text-gray-300'"
       class="flex flex-col items-center justify-center gap-1 w-full py-1 rounded-lg cursor-pointer"
       href="#laboratory">
        <span class="material-symbols-outlined">calculate</span>
        <span class="text-xs font-medium">Araçlar</span>
    </a>
    <a @click.prevent="navigateTo('guides')"
       :class="currentRoute === 'guides' ? 'text-primary' : 'text-gray-600 dark:text-gray-300'"
       class="flex flex-col items-center justify-center gap-1 w-full py-1 rounded-lg cursor-pointer"
       href="#guides">
        <span class="material-symbols-outlined">article</span>
        <span class="text-xs font-medium">Rehberler</span>
    </a>
    <a class="flex flex-col items-center justify-center text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary gap-1 w-full py-1 rounded-lg"
       href="#"
       x-show="user">
        <div class="bg-primary/20 rounded-full size-6 flex items-center justify-center">
            <span class="material-symbols-outlined text-primary text-base">person</span>
        </div>
        <span class="text-xs font-medium">Profil</span>
    </a>
</footer>

</body>
</html>
