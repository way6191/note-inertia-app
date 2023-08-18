<script context="module">
    export { default as layout } from "../Shared/Layout.svelte";
</script>

<script>
    import { useForm } from "@inertiajs/svelte";
    export let menu;
    export let book;

    let noteFileForm = useForm("noteFileForm", {
        noteFiles: null,
    });

    const submitNoteFile = function () {
        $noteFileForm.post(`/note/upload?menu=${menu}&book=${book}`);
        $noteFileForm.reset();
    };
</script>

<div class="flex flex-col w-full">
    <form
        on:submit|preventDefault={submitNoteFile}
        class="flex justify-between"
    >
        <div>
            <input
                multiple
                type="file"
                on:input={(e) => ($noteFileForm.noteFiles = e.target.files)}
                class="file-input my-2 file-input-ghost w-full max-w-xs"
            />
            <button type="submit" class="btn btn-outline">上传</button>
        </div>
    </form>
</div>
