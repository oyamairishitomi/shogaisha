import './bootstrap';
import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Placeholder from '@tiptap/extension-placeholder'

//Article
const articleEditorEl = document.getElementById('article-editor')
if (articleEditorEl) { //articleeditorがページにあるときだけ実行する
    const initialContent = window.articleContent || ''
    const articleEditor = new Editor({
        element: articleEditorEl,
        extensions: [StarterKit],
        content: initialContent,
        onUpdate() { //onUpdateでtiptapの内容をHTMLに変換してhidden inputに流し込む
            document.getElementById('article-body-input').value = articleEditor.getHTML()
        },
    })

            document.getElementById('article-body-input').value = initialContent


    document.querySelectorAll('#article-toolbar .toolbar-btn').forEach(btn => {
        // mousedownでpreventDefaultしないとボタンクリック時にエディタのフォーカス（選択範囲）が失われる
        btn.addEventListener('mousedown', (e) => e.preventDefault())
        btn.addEventListener('click', () => {
            const cmd = btn.dataset.cmd //button data-cmd="bold"とかを取る
            if (cmd === 'bold') articleEditor.chain().focus().toggleBold().run()
            if (cmd === 'italic') articleEditor.chain().focus().toggleItalic().run()
            if (cmd === 'h2') articleEditor.chain().focus().toggleHeading({ level: 2 }).run()
            if (cmd === 'h3') articleEditor.chain().focus().toggleHeading({ level: 3 }).run()
            if (cmd === 'bulletList') articleEditor.chain().focus().toggleBulletList().run()
            if (cmd === 'orderedList') articleEditor.chain().focus().toggleOrderedList().run()
            if (cmd === 'paragraph') articleEditor.chain().focus().setParagraph().run()
        })
    })

    //音声入力
    const articleMicBtn = document.getElementById('article-mic-btn')
    if (articleMicBtn) {
        let articleRecorder
        let articleChunks = []

        articleMicBtn.addEventListener('click', async () => {
            if (articleRecorder && articleRecorder.state === 'recording') {
                articleRecorder.stop()
                articleMicBtn.textContent = '🎤声で入力する'
                return
            }
            
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true })
            articleRecorder = new MediaRecorder(stream)
            articleChunks = []

            articleRecorder.ondataavailable = (e) => articleChunks.push(e.data)

            articleRecorder.onstop = async () => {
                const blob = new Blob(articleChunks, { type: 'audio/webm' })
                const formData = new FormData()
                formData.append('audio', blob, 'audio.webm')

                articleMicBtn.textContent = '変換中...'

                const res = await fetch('/shogaisha/public/api/speech', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            
            const data = await res.json()
            articleEditor.commands.insertContent(data.text)
            articleMicBtn.textContent = '🎤声で入力する'
            }

            articleRecorder.start()
            articleMicBtn.textContent = '■録音中...'
        })
    }
}


//entry
const editorEl = document.querySelector('#editor')
if (editorEl) {
    const editor = new Editor({
        element: document.querySelector('#editor'),
        extensions: [StarterKit, Placeholder.configure({
            placeholder: '　ここをクリックして書き足してみませんか。AIも使えます。',
        })],
        onFocus(){
        document.querySelector('.cursor').style.display = 'none'
        },
        onBlur(){
        document.querySelector('.cursor').style.display = 'inline'
        },
        onUpdate(){
            document.querySelector('#body-input').value = editor.getHTML()
        },
    }) 

//音声入力

const micBtn = document.getElementById('mic-btn')
if (micBtn){
    let recorder
    let chunks = []

    micBtn.addEventListener('click', async () => {
        if (recorder && recorder.state === 'recording') {
            recorder.stop()
            micBtn.textContent = '🎤'
            return
        }

        const stream = await navigator.mediaDevices.getUserMedia({ audio: true })
        recorder = new MediaRecorder(stream)
        chunks = []

        recorder.ondataavailable = (e) => chunks.push(e.data)

        recorder.onstop = async () => {
            const blob = new Blob(chunks, { type: 'audio/webm' })
            const formData = new FormData()
            formData.append('audio', blob, 'audio.webm')

            micBtn.textContent = '変換中...'

            const res = await fetch('/shogaisha/public/api/speech', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            
            const data = await res.json()
            editor.commands.insertContent(data.text)
            micBtn.textContent = '🎤'
        }

        recorder.start()
        micBtn.textContent = '■'
    })
}

//モーダル開閉
    document.getElementById('open-ai-btn').addEventListener('click', () => {
    document.getElementById('ai-overlay').classList.remove('hidden')
})

document.getElementById('close-modal-btn').addEventListener('click', () => {
    document.getElementById('ai-overlay').classList.add('hidden')
})

document.getElementById('ai-overlay').addEventListener('click', (e) => {
    if (e.target === document.getElementById('ai-overlay')) {
        document.getElementById('ai-overlay').classList.add('hidden')
    }
})

// AI代筆ストリーミング
document.getElementById('ghostwrite-btn').addEventListener('click', async () => {
    const draft = document.getElementById('draft-input').value
    if (!draft) return

    const resultDiv = document.getElementById('ai-result')
    const btn = document.getElementById('ghostwrite-btn')

    resultDiv.textContent = ''
    resultDiv.classList.remove('hidden')
    document.getElementById('apply-btn').classList.add('hidden')

    btn.textContent = '生成中...'
    btn.disabled = true

    const res = await fetch(window.ghostwriteUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ draft }),
    })

    const reader = res.body.getReader()
    const decoder = new TextDecoder()

    while (true) {
    const { done, value } = await reader.read()
    if (done) break
    const lines = decoder.decode(value).split('\n')
    for (const line of lines) {
        if (!line.startsWith('data: ')) continue
        try {
            const json = JSON.parse(line.slice(6))
            if (json.type === 'text_delta' && json.delta) {
                resultDiv.textContent += json.delta
            }
        } catch {}
    }
}

    btn.textContent = '文章にする'
    btn.disabled = false
    document.getElementById('apply-btn').classList.remove('hidden')
})


// TiptapにOK
document.getElementById('apply-btn').addEventListener('click', () => {
    const text = document.getElementById('ai-result').textContent
    editor.commands.setContent(text)
    document.getElementById('use-ai-input').value = '1'
    document.getElementById('ai-overlay').classList.add('hidden')
})
}

// ルビふり
const rubySwitch = document.getElementById('ruby-switch')
if (rubySwitch) {
    if (localStorage.getItem('ruby') === 'off') {
        rubySwitch.checked = false
        document.body.classList.add('ruby-off')
    }
    rubySwitch.addEventListener('change', () => {
        const isOff = !rubySwitch.checked
        document.body.classList.toggle('ruby-off', isOff)
        localStorage.setItem('ruby', isOff ? 'off' : 'on')
    })
}