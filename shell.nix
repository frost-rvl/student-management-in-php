{
  pkgs ? import <nixpkgs> { },
}:

pkgs.mkShell {
  packages = with pkgs; [
    php
    tree
    (writeShellScriptBin "apache" "docker compose up -d web")
    (writeShellScriptBin "mariadb" "docker compose up -d db")
    (writeShellScriptBin "dodo" "docker compose down")
  ];
}
