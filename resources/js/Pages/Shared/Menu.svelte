<script>
    import { page, useForm } from "@inertiajs/svelte";
    import Title from "./Title.svelte";

    const htmlElement = document.querySelector("html");

    let isOpen = false;
    let isDark = localStorage.getItem("isDark") == "true" ? true : false;

    const darkThemes = $page.props.darkThemes;
    const lightThemes = $page.props.lightThemes;

    $: if (isDark) {
        localStorage.setItem("isDark", true);

        const darkTheme = localStorage.getItem("darkTheme");
        if (darkTheme) {
            htmlElement.setAttribute("data-theme", darkTheme);
        } else {
            htmlElement.setAttribute("data-theme", darkThemes[0]);
            localStorage.setItem("darkTheme", darkThemes[0]);
        }
    } else {
        localStorage.setItem("isDark", false);

        const lightTheme = localStorage.getItem("lightTheme");
        if (lightTheme) {
            htmlElement.setAttribute("data-theme", lightTheme);
        } else {
            htmlElement.setAttribute("data-theme", lightThemes[0]);
            localStorage.setItem("lightTheme", lightThemes[0]);
        }
    }

    const changeTheme = function () {
        if (isDark) {
            const darkTheme = localStorage.getItem("darkTheme");
            let index = darkThemes.indexOf(darkTheme) + 1;
            if (index == darkThemes.length) {
                index = 0;
            }
            const nextTheme = darkThemes[index];
            localStorage.setItem("darkTheme", nextTheme);
            htmlElement.setAttribute("data-theme", nextTheme);
        } else {
            const lightTheme = localStorage.getItem("lightTheme");
            let index = lightThemes.indexOf(lightTheme) + 1;
            if (index == lightThemes.length) {
                index = 0;
            }
            const nextTheme = lightThemes[index];
            localStorage.setItem("lightTheme", nextTheme);
            htmlElement.setAttribute("data-theme", nextTheme);
        }
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
            <div tabindex="0" class="btn btn-ghost sm:hidden">
                <i class="fa-solid fa-bars" />
            </div>
            <ul
                tabindex="0"
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
        {#if $page.props.auth.user}
            <span class="text-xs">{$page.props.auth.user.name}</span>
        {/if}
    </div>
    <div class="navbar-center hidden md:flex">
        <ul class="menu menu-horizontal flex items-end">
            {#each $page.props.menus as menu}
                <li>
                    <a href={route("menu.show", { menuName: menu.menu_name })}>
                        {menu.menu_name}
                    </a>
                </li>
            {/each}
            {#if $page.props.auth.user}
                <li>
                    <a
                        href="#"
                        class="text-xs"
                        on:click={() => (isOpen = true)}
                    >
                        <i class="fa-solid fa-plus" />
                    </a>
                </li>
            {/if}
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
            </div>
            <button type="submit" class="btn btn-outline">提交</button>
        </div>
    </form>
</dialog>
