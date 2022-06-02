@extends(config('vgplay.console.layout'))

@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.22.0/axios.min.js"
        integrity="sha512-m2ssMAtdCEYGWXQ8hXVG4Q39uKYtbfaJL5QMTbhl2kc6vYyubrKHhr6aLLXW4ITeXSywQLn1AhsAaqrJl8Acfg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var previousCommands = [''];
        var cursor = previousCommands.length - 1;
        var UP = 38;
        var DOWN = 40;
        $('#run-command').submit(function(e) {
            e.preventDefault();

            let command = $('input[name="command"]').val();

            $('input[name="command"]').val("");

            previousCommands.push(command)
            cursor = previousCommands.length - 1

            $('#console_output').append(`<p class="console text-success">> php artisan ${command}</p>`);
            $('#console_output_container').scrollTop($('#console_output_container').prop("scrollHeight") + 200);

            if (command == 'clear') {
                $('#console_output').empty();
                return;
            }

            axios.post("{{ route('console.execute') }}", {
                command
            }, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).then(res => {
                $('#console_output').append(
                    `<pre class="console text-white">${res.data?.message ? res.data?.message : 'Done!'}</pre>`
                )
            }).catch(err => {
                $('#console_output').append(
                    `<pre class="console text-danger">${err.response?.data?.message ?? 'Lỗi không xác định'}</pre>`
                )
            }).finally(function() {
                $('#console_output_container').scrollTop($('#console_output_container').prop(
                    "scrollHeight"));
            })
        })

        $('.terminal-home').click(function(e) {
            if (e.target.id == 'console_output_container') {
                $('input[name="command"]').focus();
            }
        })

        $('input[name="command"]').keydown(function(e) {
            if (e.keyCode == UP || e.keyCode == DOWN) {
                e.preventDefault();
                $(this).val(previousCommands[cursor])
                switch (e.keyCode) {
                    case UP:
                        cursor = (cursor - 1) >= 0 ? cursor - 1 : cursor
                        break;
                    case DOWN:
                        cursor = (cursor + 1) < previousCommands.length ? cursor + 1 : cursor
                        break;
                    default:
                }
            }
        })
    </script>
@endsection
