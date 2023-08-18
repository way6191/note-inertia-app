<script context="module">
    export { default as layout } from "../Shared/Layout.svelte";
</script>

<script>
    import { page } from "@inertiajs/svelte";
    import { onMount } from "svelte";
    import NavBook from "../Shared/NavBook.svelte";
    import NavNote from "../Shared/NavNote.svelte";

    let urls = decodeURI($page.url).split("/");
    $: navMenu = urls[2];
    $: navBook = urls[3];

    export let books;
    export let notes;
    export let content;

    const speechInstance = new SpeechSynthesisUtterance();
    speechInstance.rate = 0.5;
    speechInstance.lang = "ja-JP";

    // 发音模块
    const speak = function (speechInstance, element) {
        if (speechSynthesis.speaking) {
            return;
        }

        const text = element.innerText;
        speechInstance.text = text;
        const icon = element.querySelector("span");
        icon.innerHTML = '<i class="animate-spin fa-solid fa-spinner"></i>';
        speechSynthesis.speak(speechInstance);
        element.classList.add("bg-accent", "text-accent-content");

        const id = setInterval(() => {
            if (!speechSynthesis.speaking) {
                icon.innerHTML =
                    '<i class="cursor-pointer fa-solid fa-play"></i>';
                element.classList.remove("bg-accent", "text-accent-content");
                clearInterval(id);
            }
        }, 100);
    };

    // 平假名模块
    const translate = async function (sentence) {
        const data = {
            app_id: "2af343ae24e0d5865dd1b3a200c348c98a8e6a4b8656b047b074102348899df7",
            sentence: sentence,
            output_type: "hiragana",
        };

        const formResponse = await fetch(
            "https://labs.goo.ne.jp/api/hiragana",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            }
        );
        const ret = await formResponse.json();

        return ret.converted;
    };

    onMount(() => {
        // 插入发音模块
        document.querySelectorAll("article section").forEach((element) => {
            const playSpan = document.createElement("span");
            playSpan.innerHTML =
                '<i class="cursor-pointer fa-solid fa-play"></i>';
            playSpan.classList.add("mr-2");
            element.insertAdjacentElement("afterbegin", playSpan);
            playSpan.addEventListener("click", () =>
                speak(speechInstance, element)
            );
        });

        // 调用平假名
        document
            .querySelectorAll("article section strong")
            .forEach(async (element) => {
                const text = element.innerText;
                element.classList.add("tooltip", "tooltip-info");
                const ret = await translate(text);
                element.setAttribute("data-tip", ret);
            });
    });
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
