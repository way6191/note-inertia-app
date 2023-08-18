<script context="module">
    export { default as layout } from "../Shared/Layout.svelte";
</script>

<script>
    import { page } from "@inertiajs/svelte";
    import NavBook from "../Shared/NavBook.svelte";
    import NavNote from "../Shared/NavNote.svelte";

    let urls = decodeURI($page.url).split("/");
    $: navMenu = urls[2];
    $: navBook = urls[3];

    export let books;
    export let notes;
    export let content;
</script>

<!-- 文件夹 -->
<NavBook navs={books} {navMenu} />

<!-- 文件 -->
<NavNote navs={notes} {navMenu} {navBook} />

<div class="w-full h-full overflow-y-auto p-4">
    <article>
        {#if content != null}
            {@html content}
        {:else}
            还没有任何笔记哟~
        {/if}
    </article>
</div>
