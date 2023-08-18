<script>
    export let navs;
    export let navMenu;
    export let navBook;
</script>

<ul class="menu bg-base-200 w-60 rounded-r-lg hidden sm:block flex-none">
    <li>
        {#if navBook != "空"}
            <a
                href={route("note.create", { menu: navMenu, book: navBook })}
                class="flex justify-center text-xs"
            >
                <i class="fa-solid fa-plus" />
            </a>
        {:else}
            请先创建分类
        {/if}
    </li>
    {#each navs as navNote}
        <li>
            <a
                href={route("note.show", {
                    menuName: navMenu,
                    bookName: navBook,
                    noteName: navNote.note_name,
                })}
            >
                <i class="fa-solid fa-file-lines" />
                <span>{navNote.note_name}</span>
            </a>
        </li>
    {/each}
</ul>
