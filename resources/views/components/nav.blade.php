<nav class="nav">
    <a href="/creative" class="nav__link {{ request()->is('creative') ? 'nav__link--active' : '' }}">творчество</a>
    <a href="/blog" class="nav__link {{ request()->is('blog') ? 'nav__link--active' : '' }}">блог</a>
    <a href="/projects" class="nav__link {{ request()->is('projects') ? 'nav__link--active' : '' }}">проекты</a>
    <a href="https://github.com/denisunderonov" target="_blank" class="nav__link">гитхаб</a>
    <a href="https://letterboxd.com/denisunderonov/" target="_blank" class="nav__link">леттербоксэд</a>
    <a href="https://t.me/denisunderonov" target="_blank" class="nav__link">телеграм</a>
</nav>
