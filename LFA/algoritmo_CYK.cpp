#include <iostream>
#include <string>
#include <vector>

bool verif_a_b(const std::string& input) {
    size_t As = 0;
    size_t Bs = 0;

    for (size_t i = 0; i < input.length(); ++i) {
        if (input[i] == 'a') {
            As++;
        }
        else if (input[i] == 'b') {
            Bs++;
        }
        else {
            return false;
        }

        if (Bs > As) {
            return false;
        }
    }

    if (As != Bs) {
        return false;
    }

    // Verifica se todos os 'a's estão antes dos 'b's
    bool b_encontrado = false;
    for (size_t i = 0; i < input.length(); ++i) {
        if (input[i] == 'b') {
            b_encontrado = true;
        }
        else if (b_encontrado && input[i] == 'a') {
            return false;
        }
    }

    return true;
}


bool cyk(const std::string& input) {
    size_t n = input.length();
    std::vector<std::vector<bool>> P(n, std::vector<bool>(n, false));

    for (size_t s = 0; s < n; ++s) {
        if (input[s] == 'a') {
            P[0][s] = true;
        }
        else if (input[s] == 'b') {
            P[s][0] = true;
        }
    }

    for (size_t l = 2; l <= n; l++) {
        for (size_t s = 0; s <= n - l; ++s) {
            for (size_t p = 0; p <= l - 1; p++) {
                if (P[p][s] && P[l - p - 1][s + p + 1]) {
                    P[l - 1][s] = true;
                    break;
                }
            }
        }
    }

    return P[n - 1][0] && (n % 2 == 0);
}

int main() {
    std::string input;
    std::cout << "Informe a entrada: ";
    std::cin >> input;

    if (cyk(input) && verif_a_b(input)) {
        std::cout << "A entrada pertence à linguagem L.\n";
    }
    else {
        std::cout << "A entrada não pertence à linguagem L.\n";
    }

    std::cin.get();
}