# CakePHP Synapse (MCP) setup

This project already includes the Synapse plugin and exposes an MCP server via:

```bash
bin/cake synapse server
```

## 1) Verify Synapse is installed + loaded

```bash
composer show josbeir/cakephp-synapse
bin/cake plugin list
```

You should see `Synapse` as loaded for CLI usage.

## 2) Optional: (Re)index docs

Synapse can index CakePHP documentation locally (SQLite FTS).

```bash
bin/cake synapse index -d
bin/cake synapse index
```

## 3) Quick local test (manual)

For a quick interactive test with MCP Inspector (requires Node.js/npx):

```bash
bin/cake synapse server --inspect
```

## 4) Configure your MCP client

Synapse typically uses stdio transport, so the client launches the command and talks over stdin/stdout.

Most clients need a config like:

```json
{
  "mcpServers": {
    "mural5": {
      "command": "/home/luis/Html/mural5/bin/cake",
      "args": ["synapse", "server"]
    }
  }
}
```

If your client supports passing a working directory, set it to the project root.

### Trae IDE

Trae supports both global MCP configuration (via Settings UI) and project-level configuration via `.trae/mcp.json`.

Example configuration:

```json
{
  "mcpServers": {
    "mural5-synapse": {
      "command": "/home/luis/Html/mural5/bin/cake",
      "args": ["synapse", "server"],
      "env": {
        "START_MCP_TIMEOUT_MS": "60000",
        "RUN_MCP_TIMEOUT_MS": "60000"
      }
    }
  }
}
```

### Claude Desktop

Add the `mcpServers` config in Claude Desktop settings (it writes a JSON file similar to the snippet above).

### Claude Code

Configure an MCP server entry that runs:

- command: `bin/cake`
- args: `synapse`, `server`

## 5) Security notes

Synapse includes a `tinker` tool that can execute arbitrary PHP in your app context. Only run it against trusted local/dev environments.
