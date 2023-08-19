<script context="module">
    export { default as layout } from "./Shared/Layout.svelte";
</script>

<script>
    import { useForm } from "@inertiajs/svelte";
    let loginForm = useForm({
        username: null,
        password: null,
    });

    function submitLogin() {
        $loginForm.post(route("login"));
    }
</script>

<form
    on:submit|preventDefault={submitLogin}
    class="form-control w-full max-w-xs mx-auto flex justify-center"
>
    <div>
        <label for="" class="label">
            <span class="label-text">用户名</span>
        </label>
        <input
            bind:value={$loginForm.username}
            type="text"
            placeholder="请输入用户名"
            class="input input-bordered w-full max-w-xs"
        />
        <label for="" class="label">
            <span class="label-text">密码</span>
        </label>
        <input
            bind:value={$loginForm.password}
            type="password"
            placeholder="请输入密码"
            class="input input-bordered w-full max-w-xs"
        />
    </div>
    <button type="submit" class="btn mt-4">登录</button>
</form>
