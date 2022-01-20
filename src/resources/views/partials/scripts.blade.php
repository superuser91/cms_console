<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.22.0/axios.min.js"
integrity="sha512-m2ssMAtdCEYGWXQ8hXVG4Q39uKYtbfaJL5QMTbhl2kc6vYyubrKHhr6aLLXW4ITeXSywQLn1AhsAaqrJl8Acfg=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var previousCommands = [''];
    var cursor = previousCommands.length - 1;
    const UP = 38;
    const DOWN = 40;
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

        axios.post("{{ config('cms_console.post_end_point') }}", {
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
