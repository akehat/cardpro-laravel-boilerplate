<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @include('partials.header')
</head>
<body>
<ul class="max-w-2xl mx-auto mt-20 divide-y  shadow shadow-blue-600 rounded-xl">
    <li>
        <details class="group">
            <summary class="flex items-center gap-3 px-4 py-3 font-medium marker:content-none hover:cursor-pointer">
                <svg class="w-5 h-5 text-gray-500 transition group-open:rotate-90" xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z">
                    </path>
                </svg>
                <span>Question one?</span>
            </summary>

            <article class="px-4 pb-4">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et ipsum sapien. Vestibulum molestie
                    porttitor augue vitae vulputate. Aliquam nec ex maximus, suscipit diam vel, tristique tellus.
                </p>
            </article>
        </details>
    </li>
    <li>
        <details class="group">
            <summary class="flex items-center gap-3 px-4 py-3 font-medium marker:content-none hover:cursor-pointer">
                <svg class="w-5 h-5 text-gray-500 transition group-open:rotate-90" xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z">
                    </path>
                </svg>
                <span>Question two?</span>
            </summary>

            <article class="px-4 pb-4">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et ipsum sapien. Vestibulum molestie
                    porttitor augue vitae vulputate. Aliquam nec ex maximus, suscipit diam vel, tristique tellus. </p>
            </article>
        </details>
    </li>
    <li>
        <details class="group">
            <summary class="flex items-center gap-3 px-4 py-3 font-medium marker:content-none hover:cursor-pointer">
                <svg class="w-5 h-5 text-gray-500 transition group-open:rotate-90" xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z">
                    </path>
                </svg>
                <span>Question 3?</span>
            </summary>

            <article class="px-4 pb-4">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et ipsum sapien. Vestibulum molestie
                    porttitor augue vitae vulputate. Aliquam nec ex maximus, suscipit diam vel, tristique tellus. </p>
            </article>
        </details>
    </li>
    <li>
        <details class="group">
            <summary class="flex items-center gap-3 px-4 py-3 font-medium marker:content-none hover:cursor-pointer">
                <svg class="w-5 h-5 text-gray-500 transition group-open:rotate-90" xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z">
                    </path>
                </svg>
                <span>Question 4?</span>
            </summary>

            <article class="px-4 pb-4">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et ipsum sapien. Vestibulum molestie
                    porttitor augue vitae vulputate. Aliquam nec ex maximus, suscipit diam vel, tristique tellus. </p>
            </article>
        </details>
    </li>

</ul>
@include('partials.footer')
</body>
</html>