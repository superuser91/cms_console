<style>
    @import url('https://fonts.googleapis.com/css?family=Roboto+Mono');

    p.console {
        font-family: 'Roboto Mono', monospace;
        white-space: pre-wrap;
        word-wrap: break-word;
        word-break: break-all;
    }

    pre.console {
        white-space: pre-wrap;
        word-wrap: break-word;
        word-break: break-all;
    }

    header.terminal {
        background: #E0E8F0;
        height: 30px;
        border-radius: 8px 8px 0 0;
        padding-left: 10px;
    }

    .terminal-container header .button {
        width: 12px;
        height: 12px;
        margin: 10px 4px 0 0;
        display: inline-block;
        border-radius: 8px;
    }

    .green {
        background-color: #3BB662 !important;
    }

    .red {
        background-color: #E75448 !important;
    }

    .yellow {
        background-color: #E5C30F !important;
    }

    .terminal-container {
        text-align: left;
        width: 100%;
        border-radius: 10px;
        margin: auto;
        margin-bottom: 14px;
        position: relative;
        height: 500px;
    }

    .terminal-fixed-top {
        margin-top: 30px;
    }

    .terminal-home {
        background-color: #30353A;
        padding: 1.5em 1em 1em 2em;
        border-bottom-left-radius: 6px;
        border-bottom-right-radius: 6px;
        color: #FAFAFA;
        height: 100%;
    }

</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        @if (session('status'))
            <div class="alert alert-custom alert-success alert-shadow gutter-b w-100 mx-4" role="alert">
                <div class="alert-icon">
                    <i class="fas fa-torii-gate"></i>
                </div>
                <div class="alert-text">
                    {{ session('status') }}
                </div>
            </div>
        @endif
        <div class="col-md-12">
            <form id="run-command">
                <section class="terminal-container terminal-fixed-top" id="terminal-container">
                    <header class="terminal">
                        <span class="button red"></span>
                        <span class="button yellow"></span>
                        <span class="button green"></span>
                    </header>

                    <div class="terminal-home overflow-auto" id="console_output_container">
                        <div id="console_output">
                            <p class="console">admin@server:/www/# php artisan command</p>
                        </div>
                        <p class="console d-flex">
                            <span>admin@server:/www/#</span>
                            <input type="text" class="flex-grow-1 text-white" name="command"
                                style="background-color:#30353A;outline:none;border:none;word-break: break-all;">
                        </p>
                    </div>
                </section>
            </form>

        </div>
    </div>
</div>
