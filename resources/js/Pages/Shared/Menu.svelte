<script>
    import { page, useForm } from "@inertiajs/svelte";
    import Title from "./Title.svelte";

    const lightThemes = $page.props.lightThemes;
    const darkThemes = $page.props.darkThemes;
    const htmlElement = document.querySelector("html");

    let themes = lightThemes;
    let index = themes.length;

    let isOpen = false;
    let isDark = false;

    $: if (isDark) {
        themes = darkThemes;
        index = themes.length;
        htmlElement.setAttribute("data-theme", themes[0]);
    } else {
        themes = lightThemes;
        index = themes.length;
        htmlElement.setAttribute("data-theme", themes[0]);
    }

    const changeTheme = function () {
        index--;
        if (index == 0) {
            index = themes.length;
        }
        htmlElement.setAttribute("data-theme", themes[themes.length - index]);
    };

    let menuForm = useForm({
        menuName: null,
    });

    const submitMenu = function () {
        $menuForm.post(route("menu.store"));
        $menuForm.reset();
        isOpen = false;
    };
</script>

<div class="navbar border-b-2">
    <div class="navbar-start">
        <div class="dropdown">
            <div class="btn btn-ghost sm:hidden">
                <i class="fa-solid fa-bars" />
            </div>
            <ul
                class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52"
            >
                {#each $page.props.menus as menu}
                    <li>
                        <a
                            href={route("menu.show", {
                                menuName: menu.menu_name,
                            })}
                        >
                            {menu.menu_name}
                        </a>
                    </li>
                {/each}
            </ul>
        </div>

        <Title />

        <span class="text-xs">way</span>
    </div>
    <div class="navbar-center hidden md:flex">
        <ul class="menu menu-horizontal flex items-end">
            {#each $page.props.menus as menu}
                <li>
                    <a href="/note/{menu.menu_name}">{menu.menu_name}</a>
                </li>
            {/each}
            <li>
                <a href="#" class="text-xs" on:click={() => (isOpen = true)}>
                    <i class="fa-solid fa-plus" />
                </a>
            </li>
        </ul>
    </div>
    <div class="navbar-end">
        <a href="#" on:click={changeTheme}>
            <i class="text-2xl mx-2 fa-solid fa-arrows-rotate" />
        </a>

        <label class="text-2xl mx-2 swap swap-rotate">
            <!-- this hidden checkbox controls the state -->
            <input type="checkbox" bind:checked={isDark} />

            <!-- sun icon -->
            <i class="swap-off fa-regular fa-sun" />

            <!-- moon icon -->
            <i class="swap-on fa-regular fa-moon" />
        </label>
    </div>
</div>

<dialog open={isOpen} class="modal">
    <form on:submit|preventDefault={submitMenu} class="modal-box">
        <button
            on:click={() => (isOpen = false)}
            type="reset"
            class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
            >✕</button
        >
        <h3 class="font-bold text-lg">新建文档</h3>
        <div class="my-4 flex justify-between">
            <div>
                <input
                    bind:value={$menuForm.menuName}
                    type="text"
                    placeholder="文档名"
                    class="input input-bordered w-full max-w-xs"
                />
                {#if $menuForm.errors.menuName}
                    <div class="text-xs text-red-500">
                        {$menuForm.errors.menuName}
                    </div>
                {/if}
            </div>
            <button type="submit" class="btn btn-outline">提交</button>
        </div>
    </form>
</dialog>
