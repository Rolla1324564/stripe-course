<!-- Navigation Bar -->
<nav class="bg-white dark:bg-[#161615] shadow-sm dark:shadow-none border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo/Brand -->
            <div class="flex-shrink-0">
                <a href="{{ route('courses.index') }}" class="text-2xl font-bold text-[#F53003] dark:text-[#FF4433]">
                    EduStrike
                </a>
            </div>

            <!-- Menu Items -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="{{ route('courses.index') }}" 
                   class="px-3 py-2 rounded-md text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-[#f5f5f5] dark:hover:bg-[#3E3E3A] transition-colors
                   {{ request()->routeIs('courses.index') ? 'bg-[#f5f5f5] dark:bg-[#3E3E3A]' : '' }}">
                    Home
                </a>
                
                <a href="#about" 
                   class="px-3 py-2 rounded-md text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-[#f5f5f5] dark:hover:bg-[#3E3E3A] transition-colors">
                    About
                </a>
                
                <a href="{{ route('courses.index') }}" 
                   class="px-3 py-2 rounded-md text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-[#f5f5f5] dark:hover:bg-[#3E3E3A] transition-colors
                   {{ request()->routeIs('courses.index') ? 'bg-[#f5f5f5] dark:bg-[#3E3E3A]' : '' }}">
                    Courses
                </a>
            </div>

            <!-- Login Button -->
            <div>
                <a href="{{ route('admin.login') }}" 
                   class="inline-block px-4 py-2 rounded-md text-sm font-medium text-white bg-[#F53003] hover:bg-[#d41f02] transition-colors dark:bg-[#FF4433] dark:hover:bg-[#ff3318]">
                    Login
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile Menu (Optional for later) -->
    <div class="md:hidden px-2 pt-2 pb-3 space-y-1 sm:px-3 hidden" id="mobile-menu">
        <a href="{{ route('courses.index') }}" 
           class="block px-3 py-2 rounded-md text-base font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-[#f5f5f5] dark:hover:bg-[#3E3E3A]">
            Home
        </a>
        <a href="#about" 
           class="block px-3 py-2 rounded-md text-base font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-[#f5f5f5] dark:hover:bg-[#3E3E3A]">
            About
        </a>
        <a href="{{ route('courses.index') }}" 
           class="block px-3 py-2 rounded-md text-base font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-[#f5f5f5] dark:hover:bg-[#3E3E3A]">
            Courses
        </a>
    </div>
</nav>
