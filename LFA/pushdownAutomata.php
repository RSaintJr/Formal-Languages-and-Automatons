
<?php
function delta($state, $input, $stackTop) {
    $transitions = [
        "q0" => [
            "a" => ["state" => "q0", "pop" => false, "push" => "a"],
            "b" => ["state" => "q0", "pop" => false, "push" => "b"],
            "X" => ["state" => "q1", "pop" => false, "push" => null],
        ],
        "q1" => [
            "a" => ["state" => "q1", "pop" => "a", "push" => null],
            "b" => ["state" => "q1", "pop" => "b", "push" => null],
        ],
    ];

    if (isset($transitions[$state][$input]) && ($transitions[$state][$input]["pop"] === false || $transitions[$state][$input]["pop"] === $stackTop)) {
        return $transitions[$state][$input];
    }

    return null;
}



function isAccepted($word) {
    $sigma = ["a", "b", "X"];
    $stack = [];
    $state = "q0";

    for ($i = 0; $i < strlen($word); $i++) {
        $input = $word[$i];
        if (!in_array($input, $sigma)) return false;

        $stackTop = end($stack);
        $newState = delta($state, $input, $stackTop);

        if ($newState === null) return false;

        $state = $newState["state"];
        if ($newState["pop"]) array_pop($stack);
        if ($newState["push"] !== null) $stack[] = $newState["push"];
    }

    return $state == "q1" && count($stack) == 0;
}

$word = "abbXbba";
echo isAccepted($word) ? "Aceito" : "Rejeitado";
?>