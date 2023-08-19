<script>
    export let navs;
    export let navMenu;

    import { page, useForm } from "@inertiajs/svelte";
    const urls = decodeURI($page.url).split("/");
    const activeBook = urls[3];

    let isOpen = false;

    let bookForm = useForm({
        menuName: navMenu,
        bookName: null,
    });

    const submitBook = function () {
        $bookForm.post(route("book.store"));
        $bookForm.reset();
        isOpen = false;
    };
</script>

<ul
    class="menu bg-base-200 w-40 hidden lg:block flex-none mr-1 overflow-y-auto"
>
    <li>
        <a
            href="#"
            class="flex justify-center text-xs"
            on:click={() => (isOpen = true)}
        >
            <i class="fa-solid fa-plus" />
        </a>
    </li>
    {#each navs as navBook}
        <li class="text-base">
            <a
                class={activeBook == navBook.book_name &&
                    "bg-primary text-primary-content"}
                href={route("book.show", {
                    menuName: navMenu,
                    bookName: navBook.book_name,
                })}
            >
                <i class="fa-solid fa-book" />
                <span>{navBook.book_name}</span>
            </a>
        </li>
    {/each}
</ul>

<dialog open={isOpen} class="modal">
    <form on:submit|preventDefault={submitBook} class="modal-box">
        <button
            on:click={() => (isOpen = false)}
            type="reset"
            class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
            >✕</button
        >
        <h3 class="font-bold text-lg">文档({$bookForm.menuName}) 新建分类</h3>
        <div class="my-4 flex justify-between">
            <div>
                <input
                    bind:value={$bookForm.bookName}
                    type="text"
                    placeholder="分类名"
                    class="input input-bordered w-full max-w-xs"
                />
                {#if $bookForm.errors.bookName}
                    <div class="text-xs text-red-500">
                        {$bookForm.errors.bookName}
                    </div>
                {/if}
            </div>
            <button type="submit" class="btn btn-outline">提交</button>
        </div>
    </form>
</dialog>
