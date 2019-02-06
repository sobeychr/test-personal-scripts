<main class='main'>
    <form action='' autocomplete='off' enctype='text/plain' method='post' novalidate class='clearfix tstodate' data-action='tstodate'>
        <button type='submit' class='submit'></button>
        <div>Timestamp to Date</div>
        <div class='input'>
            <div>
                <input type='number' class='input__value' required placeholder='123456789'/>
            </div>
            <div>
                <label class='checkbox'>
                    <input type='checkbox' class='toggle'/>
                    Javascript TS
                </label>
            </div>
        </div>
        <pre class='output'></pre>
    </form>

    <form action='' autocomplete='off' enctype='text/plain' method='post' novalidate class='clearfix datetots' data-action='datetots'>
        <button type='submit' class='submit'></button>
        <div>Date to Timestamp</div>
        <div class='input'>
            <div>
                <input type='date' class='input__value-date' required palceholder='yyyy-mm-dd'/>
                <input type='text' class='input__value-time' required placeholder='00:00:00'/>
            </div>
            <div>
                <label class='checkbox'>
                    <input type='checkbox' class='toggle'/>
                    Javascript TS
                </label>
            </div>
        </div>
        <pre class='output'></pre>
    </form>
</main>
