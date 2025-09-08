<form id="shorten-form" action="/api/v1/shorten">
    <label for="url">URL</label>
    <input type="url" name="url" id="url" placeholder="https://example.com/long-url" pattern="https?://.+\/.+" required>
    <button type="submit">Shorten</button>
</form>

<div id="shorten-result" class="shorten-result"></div>
