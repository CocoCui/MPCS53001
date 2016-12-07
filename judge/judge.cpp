#include <iostream>
#include <stdlib.h>
#include <stdio.h>
#include <time.h>
#include <signal.h>
#include <unistd.h>
#include <sstream>
#include <fstream>
#include <vector>
using namespace std;
int debug = 0;
struct Result{
    string res;
    int runtime;
    int memory;
}r[100];

string int2string(int i) {
    stringstream ss;
    ss << i;
    string res;
    ss >> res;
    return res;
}

Result final;

void verify(int caseid, string submission, int runtime) {
    string output = submission + "/" + int2string(caseid) + ".res";
    string answer = submission + "/" + int2string(caseid) + ".out";
    ifstream fin1(output), fin2(answer);
    int r1, r2, wrong = 0;
    string line1, line2;
    vector<string> res1, res2;
    while(getline(fin1, line1)) res1.push_back(line1);
    while(getline(fin2, line2)) res2.push_back(line2);
    if(res1.size() < res2.size()) {
        r[caseid].res = "Wrong Answer";
        r[caseid].runtime = -1;
        r[caseid].memory = 0;
        return;
    }
    for(int i = 0; i < res2.size(); i++) {
        if(res1[i] != res2[i]) {
            r[caseid].res = "Wrong Answer";
            r[caseid].runtime = -1;
            r[caseid].memory = 0;
            return;
        }
    }
    r[caseid].res = "Pass";
    r[caseid].runtime = runtime;
    r[caseid].memory = 0;
    return;
}

void test(int caseid, string submission) {
    pid_t pid = fork();
    if(pid == -1) {
        cout << "ERROR" << endl;
        return;
    }
    if(pid == 0) {
        string input = submission + "/" + int2string(caseid) + ".in";
        string output = submission + "/" + int2string(caseid) + ".res";
        string exec = submission + "/main";
        freopen(input.c_str(), "r", stdin);
        freopen(output.c_str(), "w", stdout);
        execl(exec.c_str(),NULL);
        fclose(stdin);
        fclose(stdout);
        return;
    }
    else{
        pid_t w;
        int status;
        clock_t start = clock(), cur;
        int runtime;
        while(1) {
            cur = clock();
            w = waitpid(pid, &status, WNOHANG);
            if(w != 0) {
                runtime = (cur - start) / 1000;
                verify(caseid, submission, cur - start);
                if(debug) cout << "Test:" << caseid << " finished, " << "result: " << r[caseid].res << ", runtime: " << runtime << endl;
                break;
            }
            if(cur - start > 1000000) {
                kill(pid, SIGTERM);
                waitpid( pid, &status, 0 );
                if(debug) cout << "Test:" << caseid << " TLE." << endl;
                r[caseid].res = "Time Out";
                r[caseid].runtime = -1;
                r[caseid].memory = -1;
                break;
            }

        }
        return;
    }
}

void getResult(int cases) {
    long long runtime = 0;
    for(int i = 0; i < cases; i++) {
        if(r[i].res != "Pass") {
            final.res = r[i].res + " on TestCase " + int2string(i);
            final.runtime = -1;
            final.memory = 0;
            return;
        }
        runtime += r[i].runtime;
    }
    final.res = "Accept";
    final.runtime = runtime / 1000;
    final.memory = 0;
    return;
}

int main(int argc,char** argv) {
    int testcases = atoi(argv[2]);
    string submission = string(argv[1]);
    string compileCmd = "g++ " + submission + "/" + submission + ".cpp -o " + submission + "/main";
    string cleanCmd = "rm " + submission + "/*.res";
    system(cleanCmd.c_str());
    system(compileCmd.c_str());
    if(debug) cout << "Judge Submission:" << submission << endl; 
    string exec = submission + "/main";
    if( access(exec.c_str() , 0 ) != -1 ){
        if(debug) cout << "Compile Success!" << endl;
        for(int i = 0; i < testcases; i++) {
            test(i, submission);
        }
        getResult(testcases);
        cout << final.res << endl;
        cout << final.runtime << endl;
        cout << 0 << endl;
    } else{
        cout << "Compile Error" << endl;
        cout << -1 << endl;
        cout << 0 << endl;
    }
}
